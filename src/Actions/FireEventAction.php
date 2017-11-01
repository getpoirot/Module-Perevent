<?php
namespace Module\Perevent\Actions;

use Module\Foundation\Actions\aAction;
use Module\HttpFoundation\Events\Listener\ListenerDispatch;
use Poirot\Application\Exception\exRouteNotMatch;


class FireEventAction
    extends aAction
{
    function __invoke($perevent = null, $cmd_hash = null)
    {
        /*
        $p = \Module\Apanaj\Services\Repository::Perevents();
        $p->insert(new PereventEntity([
            'uid'     => 'x12345',
            'command' => 'user_setAmount',
            'args'    => [ ],
        ]));
        die();
        */

        if (! \Module\Perevent\Services::Perevent()->has($perevent) )
            throw new exRouteNotMatch(sprintf(
                'Perevent (%s) not found.'
                , $perevent
            ));

        $manager = \Module\Perevent\Services::Perevent()->get($perevent);
        $result  = $manager->fireEvent($cmd_hash, ['cmd_hash' => $cmd_hash]);

        return [ ListenerDispatch::RESULT_DISPATCH => $result ];
    }
}
