<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Speciality>
 */
class SpecialityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $specialities = [
            'Cardiologie' => 'Traitement des maladies du cœur et des vaisseaux',
            'Dermatologie' => 'Traitement des maladies de la peau',
            'Gynécologie' => 'Suivi médical des femmes et traitement des pathologies de l\'appareil reproducteur',
            'Pédiatrie' => 'Suivi médical des enfants et adolescents',
            'Psychiatrie' => 'Traitement des troubles mentaux',
            'Radiologie' => 'Diagnostic par imagerie médicale',
            'Médecine générale' => 'Soins médicaux primaires et de routine'
        ];

        $name = $this->faker->unique()->randomElement(array_keys($specialities));
        
        return [
            'name' => $name,
            'description' => $specialities[$name],
        ];
    }
}
