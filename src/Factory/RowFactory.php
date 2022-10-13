<?php

declare(strict_types=1);
/**
 * MIT License
 * Copyright (c) 2022 Electronic Student Services @ Appalachian State University
 *
 * See LICENSE file in root directory for copyright and distribution permissions.
 *
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */

namespace faq\Factory;

use faq\AbstractClass\AbstractFactory;
use faq\Resource\Award;
use phpws2\Database;
use Canopy\Request;
use faq\Exception\ResourceNotFound;

class RowFactory extends AbstractFactory
{

    protected static string $table = 'faq_qa';
    protected static string $resourceClassName = 'faq\Resource\Row';

    public static function activate(int $awardId, bool $active)
    {
        /**
         * @var \phpws2\Database\DB $db
         * @var \phpws2\Database\Table $table
         */
        extract(self::getDBWithTable());
        $table->addValue('active', $active);
        $table->addFieldConditional('id', $awardId);
        return $db->update();
    }

    /**
     * Clears the current cycle id from the award.
     * @param int $awardId
     */
    public static function clearCycle(int $awardId)
    {
        $award = self::build($awardId);
        $award->setCurrentCycleId(0);
        self::save($award);
    }

    /**
     * Flips the deleted flag on the Award resource and saves it.
     * @param int $awardId
     */
    public static function delete(int $awardId)
    {
        $award = self::build($awardId);
        $award->setDeleted(true);
        self::save($award);
        CycleFactory::deleteByAwardId($award->id);
    }

    public static function getList(array $options = [])
    {
        /**
         * @var \phpws2\Database\DB $db
         * @var \phpws2\Database\Table $table
         */
        extract(self::getDBWithTable());

        $result = $db->select();
        return $result;
    }

    /**
     * Returns true if the award currently has associated cycles.
     * @param int $awardId
     * @return bool
     */
    public static function hasCycles(int $awardId): bool
    {
        $db = parent::getDB();
        $table = $db->addTable('award_cycle');
        $table->addFieldConditional('awardId', $awardId);
        $db->setLimit(1);
        return (bool) $db->selectOneRow();
    }

    /**
     * Returns an array of values a participant doesn't need from
     * an award object.
     */
    public static function participantIgnoreValues(): array
    {
        return [
            'active', 'approvalRequired', 'creditNominator',
            'deleted', 'judgeMethod', 'tipNominate', 'winnerAmount',
            'defaultVoteType'
        ];
    }

    /**
     * Parses the Request for post values to fill an award object.
     * @param Request $request
     */
    public static function post(Request $request)
    {
        $award = self::build();
        // New awards are deactivated by default.
        $award->setActive(false);

        $award->setApprovalRequired($request->pullPostBoolean('approvalRequired'));
        $award->setCreditNominator($request->pullPostBoolean('creditNominator'));
        $award->setCycleTerm($request->pullPostString('cycleTerm'));
        $award->setDefaultVoteType($request->pullPostString('defaultVoteType', true) ?? AWARD_DEFAULT_VOTE_TYPE);
        $award->setDescription($request->pullPostString('description'));
        $award->setJudgeMethod($request->pullPostInteger('judgeMethod'));
        $award->setNominationReasonRequired($request->pullPostBoolean('nominationReasonRequired'));
        $award->setParticipantId($request->pullPostInteger('participantId'));
        $award->setPublicView($request->pullPostBoolean('publicView'));
        $award->setReferenceReasonRequired($request->pullPostBoolean('referenceReasonRequired'));
        $award->setReferencesRequired($request->pullPostInteger('referencesRequired'));
        $award->setSelfNominate($request->pullPostBoolean('selfNominate'));
        $award->setTitle($request->pullPostString('title'));
        $award->setTipNominated($request->pullPostBoolean('tipNominated'));
        $award->setWinnerAmount($request->pullPostInteger('winnerAmount'));
        return $award;
    }

    /**
     * Parses the Request for put values to fill an award object.
     * The active parameter is not set in the put.
     * @param Request $request
     */
    public static function put(Request $request, int $id)
    {
        $award = self::build($id);

        $award->setApprovalRequired($request->pullPutBoolean('approvalRequired'));
        $award->setCreditNominator($request->pullPutBoolean('creditNominator'));
        if (AwardFactory::hasCycles($award->id) === false) {
            $award->setCycleTerm($request->pullPutString('cycleTerm'));
        }
        $award->setDefaultVoteType($request->pullPutString('defaultVoteType', true) ?? AWARD_DEFAULT_VOTE_TYPE);
        $award->setDescription($request->pullPutString('description'));
        $award->setJudgeMethod($request->pullPutInteger('judgeMethod'));
        $award->setNominationReasonRequired($request->pullPutBoolean('nominationReasonRequired'));
        $award->setParticipantId($request->pullPutInteger('participantId'));
        $award->setPublicView($request->pullPutBoolean('publicView'));
        $award->setReferenceReasonRequired($request->pullPutBoolean('referenceReasonRequired'));
        $award->setReferencesRequired($request->pullPutInteger('referencesRequired'));
        $award->setSelfNominate($request->pullPutBoolean('selfNominate'));
        $award->setTitle($request->pullPutString('title'));
        $award->setTipNominated($request->pullPutBoolean('tipNominated'));
        $award->setWinnerAmount($request->pullPutInteger('winnerAmount'));
        return $award;
    }

    /**
     * Sets the currentCycleId of an Award to the passed in Cycle resource.
     * @param \award\Resource\Cycle $cycle
     */
    public static function setCurrentCycle(Cycle $cycle)
    {
        $award = self::build($cycle->awardId);
        $award->setCurrentCycleId($cycle->id);
        self::save($award);
    }

}
