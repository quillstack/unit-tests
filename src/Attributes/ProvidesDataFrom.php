<?php

namespace Quillstack\UnitTests\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class ProvidesDataFrom
{
    public function __construct(public string $dataProvider)
    {
        //
    }
}
