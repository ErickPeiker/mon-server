<?php

namespace App\Repository;

use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;
use App\Entity\Widget;
use App\Enumerator\WidgetType;

class WidgetRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Widget::class;
    }

    public function prePersist($entity)
    {
        // Ajusta o posicionamento do novo Widget
        $widgets = $this->findByDashboard($entity->getDashboard()->getId())->getResult();

        $y = 0;
        if (count($widgets)) {
            usort($widgets, function ($first, $second){
                return $first->getGridPosition()['y'] < $second->getGridPosition()['y'];
            });
            $y = $widgets[0]->getGridPosition()['y'] + $widgets[0]->getGridPosition()['h'];
        }

        $entity->setGridPosition([
            'x' => 0,
            'y' => $y,
            'w' => 3,
            'h' => 2,
        ]);

        // Valores padrões
        if ($entity->getType() === WidgetType::WIDGET_CHART) {
            $parameters = $entity->getParameters();

            $parameters['showOthers'] = isset($parameters['showOthers']) ? $parameters['showOthers'] : false;
            $parameters['showLegend'] = isset($parameters['showLegend']) ? $parameters['showLegend'] : false;

            $entity->setParameters($parameters);
        }
    }

    public function defaultFilters($queryWorker)
    {
        if (($user = $this->getUser()) && $this->getManager()->getFilters()->isEnabled('company')) {
            $queryWorker->andWhere('dashboard.company.id', 'equals', $user->getCompany()->getId());
        }
    }
}
