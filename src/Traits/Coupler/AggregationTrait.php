<?php

namespace YellowCable\Collection\Traits\Coupler;

use Exception;
use YellowCable\Collection\Aggregation;
use YellowCable\Collection\Collection;
use YellowCable\Collection\Exceptions\{DuplicateItemException,
    FailedInheritanceException,
    NotImplementedException,
    ValidationException};

/**
 * AggregationTrait is a trait that can be used if the class has a possibility of being aggregated.
 * It sets up aggregation for the specific class based on the same identifier. It
 * will try to find an existing aggregation to aggregate on, or it will instantiate
 * a new stdClass based on a AbstractCollectionAggregation.
 */
trait AggregationTrait
{
    /**
     * getIdentifier should return a human-readable identifier, which is also used as aggregation key.
     *
     * @return string
     */
    abstract public function getIdentifier(): string;

    /**
     * Aggregates the object this trait is used on, based on the getIdentifier() method in the object.
     * If the identifier is an empty string, it will generically aggregate.
     *
     * @return Aggregation
     * @throws DuplicateItemException
     * @throws NotImplementedException
     * @throws ValidationException
     * @throws FailedInheritanceException
     */
    public function aggregate(): Aggregation
    {
        if ($this instanceof Collection) {
            return Aggregation::aggregate($this);
        } else {
            throw new FailedInheritanceException("Used AggregationTrait on something other than a Collection");
        }
    }

    /**
     * Disaggregates the object from the existing aggregation.
     *
     * @return Aggregation
     * @throws NotImplementedException
     * @throws FailedInheritanceException
     */
    public function disaggregate(): Aggregation
    {
        if ($this instanceof Collection) {
            return Aggregation::disaggregate($this);
        } else {
            throw new FailedInheritanceException("Used AggregationTrait on something other than a Collection");
        }
    }


    /**
     * Will retrieve the aggregation with the same identifier as the object.
     *
     * @throws Exception
     */
    public function getAggregation(): Aggregation
    {
        return Aggregation::get($this->getIdentifier());
    }
}
