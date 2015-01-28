<?php

namespace NS\AceBundle\Form\Transformer;

/**
 * Description of EntityToJson
 *
 * @author gnat
 */
class EntityToJson extends AbstractObjectToJson
{
    /**
     * Transforms an object (issue) to a json {id: integer, string: string }
     *
     * @param  Entity|null $entity
     * @return string
     */
    public function transform($entity)
    {
        if ($entity === null)
            return null;

        if (!$entity instanceof $this->class)
            throw new \InvalidArgumentException(sprintf("Expecting entity of type '%s' but received '%s'", $this->class, get_class($entity)));

        return json_encode(array('id' => $entity->getId(), 'string' => $entity));
    }

    /**
     * Transforms an json string to an entity
     *
     * @param  string|null $jsonStr
     * @return Entity
     */
    public function reverseTransform($jsonStr)
    {
        if ($jsonStr === null)
            return null;

        $obj = json_decode($jsonStr, false);

        return $this->getEntityManager()->getReference($this->getClass(), $obj['id']);
    }
}