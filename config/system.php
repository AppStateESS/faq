<?php

/**
 * MIT License
 * Copyright (c) 2022 Electronic Student Services @ Appalachian State University
 *
 * See LICENSE file in root directory for copyright and distribution permissions.
 *
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */
/**
 * System defines. Do not alter these settings!
 */
/**
 * Defines the type of authorization types used. AppstateShibboleth is
 * obviously specific to this university. Local is expected to be in the zero slot
 * and defines a participant who has entered their email and password locally in
 * the system.
 */
define('AWARD_AUTH_TYPES', [0 => 'local', 1 => 'AppstateShibboleth']);
define('AWARD_DEFAULT_VOTE_TYPE', 'SingleVote');

/**
 * The invitation status. A refuse always will prevent the person from
 * ever being sent an email. Changes to the settings below **must** be updated in
 * scripts as well.
 */
define('AWARD_INVITATION_WAITING', 0);
define('AWARD_INVITATION_CONFIRMED', 1);
define('AWARD_INVITATION_REFUSED', 2);
define('AWARD_INVITATION_NO_CONTACT', 3);

define('AWARD_INVITE_TYPE_NEW', 0);
define('AWARD_INVITE_TYPE_JUDGE', 1);
define('AWARD_INVITE_TYPE_REFERENCE', 2);
define('AWARD_INVITE_TYPE_NOMINATED', 3);

define('AWARD_HASH_DEFAULT_TIMER_HOURS', 2);

// How many days between bulk reminders.
define('AWARD_JUDGE_REMINDER_GRACE', 2);
