<?php

/**
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */

namespace faq\Role;

class Participant extends Base
{

    public $participantId = 0;

    public function isParticipant()
    {
        return true;
    }

}
