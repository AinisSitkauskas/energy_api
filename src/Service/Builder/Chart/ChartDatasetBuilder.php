<?php

declare(strict_types=1);

namespace App\Service\Builder\Chart;

class ChartDatasetBuilder
{
    public const DATASET_COLOURS = [
        1 => [
            'backgroundColor' => 'rgba(244, 67, 54, 0.6)',
            'borderColor' => 'rgba(244, 67, 54, 1)',
        ],
        2 => [
            'backgroundColor' => 'rgba(33, 150, 243, 0.6)',
            'borderColor' => 'rgba(33, 150, 243, 1)',
        ],
        3 => [
            'backgroundColor' => 'rgba(121, 85, 72, 0.6)',
            'borderColor' => 'rgba(121, 85, 72, 1)',
        ],
        4 => [
            'backgroundColor' => 'rgba(156, 39, 176, 0.6)',
            'borderColor' => 'rgba(156, 39, 176, 1)',
        ],
        5 => [
            'backgroundColor' => 'rgba(76, 175, 80, 0.6)',
            'borderColor' => 'rgba(76, 175, 80, 1)',
        ],
        6 => [
            'backgroundColor' => 'rgba(96, 125, 139, 0.6)',
            'borderColor' => 'rgba(96, 125, 139, 1)',
        ],
        7 => [
            'backgroundColor' => 'rgba(255, 152, 0, 0.6)',
            'borderColor' => 'rgba(255, 152, 0, 1)',
        ],
        8 => [
            'backgroundColor' => 'rgba(0, 188, 212, 0.6)',
            'borderColor' => 'rgba(0, 188, 212, 1)',
        ],
        'other' => [
            'backgroundColor' => 'rgba(158, 158, 158, 0.6)',
            'borderColor' => 'rgba(158, 158, 158, 1)',
        ],
    ];

    public function build(array $consumptions): array
    {
        $datasets = [];
        foreach ($consumptions as $key => $consumption) {
            if ($key === 'total') {
                continue;
            }

            $datasets[] = [
                'label' => $consumption['title'],
                'data' => [$consumption['percentage']], // Percentage or value of this category
                'backgroundColor' => self::DATASET_COLOURS[$key]['backgroundColor'],
                'borderColor' => self::DATASET_COLOURS[$key]['borderColor'],
                'borderWidth' => 1,
            ];

        }

        return $datasets;
    }
}