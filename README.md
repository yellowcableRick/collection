## Collection
> Collection and Aggregation library for PHP8.2+

## Create object collections and be in control of iteration and access.
- You can either extend the abstract or implement and use the interfaces and traits.
- Aggregation is simple; it clears the content of the collections!

## Usage
To use a Collection, make sure you create or instantiate:
```
$collection = new ItemCollection("test", [
    new Item("1", 1, 1),
    new Item("1", 1, 1),
    new Item("1", 1, 1),
    new Item("1", 1, 1),
]);
-----------------------------------------------
$collection = new class () extends Collection
{
    public function getClass(): string
    {
        return Item::class;
    }
};
```

Aggregations are possible in the same fashion as Collections:

```
$agg = new ItemAggregation("bliep");
$agg->addCollection(new ItemCollection("test", [new Item("item", 1, 1)]), false);
```

## Notes
- Don't use stdClass if you want to serialize; PHP will not allow it.

## Contribute
Contributions are always welcome! Suggestions are only welcome in the form of code.

## License

[![CC0](https://licensebuttons.net/p/zero/1.0/88x31.png)](https://creativecommons.org/publicdomain/zero/1.0/)

To the extent possible under law, [Yellow Cable](http://yellowcable.nl) has waived all copyright and related or neighboring rights to this work.