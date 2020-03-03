<?php

namespace App\Base\Doctrine\Common\Traits;

use DateTime;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;
use ReflectionClass;
use ReflectionProperty;

trait ToArrayTrait
{
    final protected function checkOnlyExceptInArray($key, array $options = [])
    {
        if (
            (isset($options['only']) && is_array($options['only']) && !in_array($key, $options['only']))
            ||
            (isset($options['except']) && is_array($options['except']) && in_array($key, $options['except']))
        ) {
            return false;
        }

        return true;
    }

    public function toArray(array $options = [])
    {
        $reflectionClass = new ReflectionClass(get_class($this));
        $annotationReader = new AnnotationReader();

        $array = [];

        foreach ($this->getFillable() as $key) {
            if ($this->checkOnlyExceptInArray($key, $options)) {
                $reflectionProperty = new ReflectionProperty(get_class($this), $key);
                $propertyAnnotations = $annotationReader->getPropertyAnnotations($reflectionProperty);

                $column = array_filter($propertyAnnotations, function ($annotation) {
                    return $annotation instanceof ORM\Column ||
                        $annotation instanceof ODM\Field ||
                        $annotation instanceof ODM\Id;
                });

                if ($column) {
                    $column = array_values($column);
                    $column = array_shift($column);

                    if ($this->$key instanceof DateTime) {
                        $dateFormat = 'Y-m-d';

                        switch ($column->type) {
                            case 'datetime':
                                $dateFormat = 'Y-m-d H:i:s';
                                break;

                            case 'time':
                                $dateFormat = 'H:i:s';
                                break;

                            default:
                                break;
                        }
                        $array[$key] = $this->$key->format($dateFormat);
                    } elseif ($column->type == 'decimal') {
                        $array[$key] = (float) $this->$key;
                    } else {
                        $array[$key] = $this->$key;
                    }
                } else {
                    $ormMapping = array_filter($propertyAnnotations, function ($annotation) {
                        return $annotation instanceof ORM\OneToOne ||
                            $annotation instanceof ORM\OneToMany ||
                            $annotation instanceof ORM\ManyToOne ||
                            $annotation instanceof ORM\ManyToMany ||
                            $annotation instanceof ODM\EmbedOne ||
                            $annotation instanceof ODM\EmbedMany ||
                            $annotation instanceof ODM\ReferenceOne ||
                            $annotation instanceof ODM\ReferenceMany;
                    });

                    if ($ormMapping) {
                        $optionsToArray = 'toArray'.ucfirst($key);

                        if ($this->$key instanceof ArrayCollection || $this->$key instanceof PersistentCollection) {
                            $ids = [];
                            foreach ($this->$key->getValues() as $item) {
                                $ids[] = isset($options[$optionsToArray]) ? $item->toArray($options[$optionsToArray]) : $item->getId();
                            }
                            $array[$key] = $ids;
                        } else {
                            if (method_exists($this->$key, 'getId')) {
                                $array[$key] = isset($options[$optionsToArray]) ? $this->$key->toArray($options[$optionsToArray]) : $this->$key->getId();
                            } else {
                                $array[$key] = $this->$key;
                            }
                        }
                    }
                }
            }
        }

        return $array;
    }
}
