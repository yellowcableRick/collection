<?php

namespace YellowCable\Collection;

use YellowCable\Collection\Exceptions\{DoesNotExistException,
    DuplicateItemException,
    NotImplementedException,
    ValidationException};
use Exception;

/**
 * Aggregation is used to aggregate items using Collections as containers,
 * where all calculating methods should be present. Aggregation tries to
 * remove any internal collection without removing any or all additional properties
 * of the Collections. Any method within the aggregated Collections can be called
 * through the Aggregation and the output will be returned as array of results.
 *
 * Aggregation is statically stored; If you try to aggregate anything with the
 * same identifier it should be compatible with one-another. Make sure you separate
 * your aggregations by setting the correct identifiers in the Collections.
 */
abstract class Aggregation extends Collection implements AggregationInterface
{
    use AggregationStaticTrait;
    use AggregationTrait;
}