<?php
namespace Module\Perevent\Actions;

use Module\Foundation\Actions\aAction;
use Module\HttpFoundation\Events\Listener\ListenerDispatch;


class FireEventAction
    extends aAction
{
    function __invoke($cmd_hash = null)
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

        $manager = \Module\Perevent\Services::Perevent();
        $result  = $manager->fireEvent($cmd_hash);

        return [ListenerDispatch::RESULT_DISPATCH => $result];
    }
}
