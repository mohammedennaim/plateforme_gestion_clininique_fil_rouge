document.addEventListener('DOMContentLoaded', function() {
    // Récupérer la clé publique Stripe depuis une variable globale
    const stripePublicKey = window.stripePublicKey || '';
    
    // Vérifier que la clé est disponible
    if (!stripePublicKey) {
        console.error('Clé publique Stripe manquante');
        document.getElementById('submit-payment').disabled = true;
        document.getElementById('card-errors').textContent = 'Erreur de configuration de paiement. Veuillez contacter le support.';
        return;
    }
    
    // Initialiser Stripe avec votre clé publique
    const stripe = Stripe(stripePublicKey);
    const elements = stripe.elements();
    let paymentCheckInterval; // Pour stocker l'intervalle de vérification
    
    // Créer les éléments Stripe
    const style = {
        base: {
            color: '#1e293b',
            fontFamily: '"Inter", sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#94a3b8'
            }
        },
        invalid: {
            color: '#ef4444',
            iconColor: '#ef4444'
        }
    };
    
    // Créer l'élément de carte
    const card = elements.create('card', { 
        style: style,
        hidePostalCode: true // Le code postal est déjà collecté dans le formulaire
    });
    card.mount('#card-element');
    
    // Gérer les erreurs de validation de la carte
    card.addEventListener('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    
    // Gérer la soumission du formulaire
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', handleSubmit);
    
    // Réinitialiser le formulaire lors d'un clic sur "Réessayer"
    document.getElementById('retry-payment').addEventListener('click', function() {
        document.getElementById('payment-error-modal').classList.add('hidden');
    });
    
    // Mettre à jour l'URL de redirection du bouton "Voir mon rendez-vous"
    document.getElementById('view-appointment').addEventListener('click', function(e) {
        e.preventDefault();
        const appointmentId = document.getElementById('appointment-id').value;
        const transactionId = document.getElementById('transaction-id').textContent;
        
        if (appointmentId) {
            window.location.href = `/patient/appointments/${appointmentId}?payment_success=true`;
        } else {
            window.location.href = `/payment/success?transaction_id=${transactionId}`;
        }
    });
    
    // Fonction pour gérer la soumission du formulaire
    async function handleSubmit(event) {
        event.preventDefault();
        
        // Désactiver le bouton de paiement pour éviter les soumissions multiples
        const submitButton = document.getElementById('submit-payment');
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Traitement en cours...';
        
        // Afficher le modal de traitement du paiement
        const processingModal = document.getElementById('payment-processing-modal');
        processingModal.classList.remove('hidden');
        
        // Récupérer les informations du formulaire
        const cardholderName = document.getElementById('cardholder-name').value;
        const billingAddress = document.getElementById('billing-address').value;
        const billingCity = document.getElementById('billing-city').value;
        const billingPostal = document.getElementById('billing-postal').value;
        const billingCountry = document.getElementById('billing-country').value;
        const appointmentId = document.getElementById('appointment-id').value;
        
        try {
            // Créer un payment method
            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
                billing_details: {
                    name: cardholderName,
                    address: {
                        line1: billingAddress,
                        city: billingCity,
                        postal_code: billingPostal,
                        country: billingCountry
                    }
                }
            });
            
            if (error) {
                // Afficher l'erreur à l'utilisateur
                handlePaymentError(error.message);
            } else {
                // Récupérer le token CSRF
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                  document.querySelector('input[name="_token"]')?.value;
                
                if (!csrfToken) {
                    handlePaymentError('Erreur de sécurité CSRF. Veuillez rafraîchir la page.');
                    return;
                }
                
                // Appeler notre API pour traiter le paiement
                const response = await fetch('/payment/process', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        payment_method_id: paymentMethod.id,
                        amount: 45, // Montant en euros
                        currency: 'EUR',
                        description: 'Paiement consultation médicale',
                        appointment_id: appointmentId
                    })
                });
                
                if (!response.ok) {
                    // Gérer les erreurs HTTP (serveur indisponible, etc.)
                    if (response.status >= 500) {
                        handlePaymentError('Le serveur de paiement est temporairement indisponible. Veuillez réessayer plus tard.');
                    } else {
                        handlePaymentError('Erreur lors de la communication avec le serveur.');
                    }
                    return;
                }
                
                const result = await response.json();
                
                if (result.success) {
                    // Paiement réussi immédiatement
                    processingModal.classList.add('hidden');
                    
                    // Afficher l'ID de transaction dans le modal de succès
                    document.getElementById('transaction-id').textContent = result.transaction_id;
                    
                    // Afficher le modal de succès
                    const successModal = document.getElementById('payment-success-modal');
                    successModal.classList.remove('hidden');
                    
                    // Mettre à jour le bouton "Voir mon rendez-vous"
                    updateViewAppointmentButton(appointmentId, result.transaction_id);
                } else if (result.requires_action) {
                    // Une authentification supplémentaire est requise (3D Secure)
                    handleStripeAction(result.payment_intent_client_secret, appointmentId);
                } else if (result.payment_intent_id) {
                    // Le paiement est en cours de traitement (asynchrone), commencer les vérifications
                    startPaymentStatusCheck(result.payment_intent_id, appointmentId);
                    handlePaymentProcessing("Traitement du paiement en cours...");
                } else {
                    // Erreur de paiement
                    handlePaymentError(result.message || 'Erreur lors du traitement du paiement');
                }
            }
        } catch (error) {
            console.error("Erreur inattendue:", error);
            handlePaymentError("Une erreur inattendue s'est produite. Veuillez réessayer.");
        } finally {
            // Réinitialiser le bouton de paiement
            submitButton.disabled = false;
            submitButton.innerHTML = '<span>Payer 45,00 €</span><i class="fas fa-lock ml-2"></i>';
        }
    }
    
    // Gérer l'authentification supplémentaire (3D Secure)
    async function handleStripeAction(clientSecret, appointmentId) {
        try {
            const { error, paymentIntent } = await stripe.handleCardAction(clientSecret);
            
            if (error) {
                handlePaymentError(error.message);
                return;
            }
            
            // Authentification réussie, confirmer le paiement
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                              document.querySelector('input[name="_token"]')?.value;
            
            const confirmResponse = await fetch('/payment/confirm', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    payment_intent_id: paymentIntent.id,
                    appointment_id: appointmentId
                })
            });
            
            if (!confirmResponse.ok) {
                handlePaymentError('Erreur lors de la confirmation du paiement.');
                return;
            }
            
            const confirmResult = await confirmResponse.json();
            
            if (confirmResult.success) {
                // Paiement confirmé avec succès
                document.getElementById('payment-processing-modal').classList.add('hidden');
                document.getElementById('transaction-id').textContent = confirmResult.transaction_id;
                document.getElementById('payment-success-modal').classList.remove('hidden');
                
                // Mettre à jour le bouton "Voir mon rendez-vous"
                updateViewAppointmentButton(appointmentId, confirmResult.transaction_id);
                
                // Arrêter l'intervalle de vérification s'il est en cours
                if (paymentCheckInterval) {
                    clearInterval(paymentCheckInterval);
                }
            } else {
                // Si le paiement n'est pas immédiatement confirmé, commencer à vérifier périodiquement
                startPaymentStatusCheck(paymentIntent.id, appointmentId);
                handlePaymentProcessing("Traitement du paiement en cours...");
            }
        } catch (error) {
            console.error("Erreur lors de l'authentification 3D Secure:", error);
            handlePaymentError("Erreur lors de l'authentification 3D Secure. Veuillez réessayer.");
        }
    }
    
    // Démarrer la vérification périodique du statut du paiement
    function startPaymentStatusCheck(paymentIntentId, appointmentId) {
        let attempts = 0;
        
        if (paymentCheckInterval) {
            clearInterval(paymentCheckInterval);
        }
        
        paymentCheckInterval = setInterval(async function() {
            attempts++;
            
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                  document.querySelector('input[name="_token"]')?.value;
                
                const response = await fetch('/payment/check-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        payment_intent_id: paymentIntentId
                    })
                });
                
                if (!response.ok) {
                    // Ne pas interrompre la vérification en cas d'erreur réseau temporaire
                    console.error("Erreur réseau lors de la vérification du paiement:", response.status);
                    return;
                }
                
                const result = await response.json();
                
                if (result.success) {
                    if (result.status === 'succeeded') {
                        // Paiement réussi
                        clearInterval(paymentCheckInterval);
                        
                        // Masquer le modal de traitement
                        document.getElementById('payment-processing-modal').classList.add('hidden');
                        
                        // Afficher le modal de succès
                        document.getElementById('transaction-id').textContent = paymentIntentId;
                        document.getElementById('payment-success-modal').classList.remove('hidden');
                        
                        // Mettre à jour le bouton "Voir mon rendez-vous"
                        updateViewAppointmentButton(appointmentId, paymentIntentId);
                    } else if (result.status === 'canceled' || result.status === 'failed') {
                        // Paiement échoué
                        clearInterval(paymentCheckInterval);
                        handlePaymentError('Le paiement a été annulé ou a échoué.');
                    }
                }
            } catch (error) {
                console.error("Erreur lors de la vérification du statut du paiement:", error);
            }
            
            // Arrêter après 15 tentatives (environ 30 secondes)
            if (attempts >= 15) {
                clearInterval(paymentCheckInterval);
                handlePaymentError("Le délai d'attente pour la vérification du paiement a été dépassé. Veuillez vérifier votre compte pour confirmer l'état du paiement.");
            }
        }, 2000); // Vérifier toutes les 2 secondes
    }
    
    // Fonction pour afficher le modal de traitement (en attente de confirmation)
    function handlePaymentProcessing(message) {
        // Masquer le modal de traitement standard
        document.getElementById('payment-processing-modal').classList.remove('hidden');
        
        // Afficher un message de traitement en cours
        const processingMsg = document.querySelector('#payment-processing-modal p');
        processingMsg.textContent = message;
    }
    
    // Fonction pour gérer les erreurs de paiement
    function handlePaymentError(errorMessage) {
        // Masquer le modal de traitement
        document.getElementById('payment-processing-modal').classList.add('hidden');
        
        // Afficher le message d'erreur
        const errorElement = document.getElementById('error-message');
        errorElement.textContent = errorMessage || "Une erreur est survenue lors du traitement de votre paiement.";
        
        // Arrêter l'intervalle de vérification s'il est en cours
        if (paymentCheckInterval) {
            clearInterval(paymentCheckInterval);
        }
        
        // Afficher le modal d'erreur
        const errorModal = document.getElementById('payment-error-modal');
        errorModal.classList.remove('hidden');
    }
    
    // Mettre à jour l'URL du bouton "Voir mon rendez-vous"
    function updateViewAppointmentButton(appointmentId, transactionId) {
        const viewAppointmentBtn = document.getElementById('view-appointment');
        
        if (appointmentId) {
            viewAppointmentBtn.href = `/patient/appointments/${appointmentId}?payment_success=true`;
        } else {
            viewAppointmentBtn.href = `/payment/success?transaction_id=${transactionId}`;
        }
    }
});