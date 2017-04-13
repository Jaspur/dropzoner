<?php namespace Jaspur\Dropzoner;

use Illuminate\Support\Facades\Facade;

/**
 * The News facade.
 *
 * @package Codingagency\News\Facades
 * @author Jasper Koers <jasper@coding.agency>
 */
class DropzonerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'dropzoner';
    }
}
