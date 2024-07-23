<?php 
namespace OSW3\Breadcrumb\Enum;

use OSW3\Breadcrumb\Trait\EnumTrait;

enum Template: string 
{
    use EnumTrait;

    case DEFAULT   = 'default';
    case BOOTSTRAP = 'bootstrap';
}