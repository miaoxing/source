<?php

namespace MiaoxingDoc\Source {

    /**
     * @property    \Miaoxing\Source\Service\Source $source
     * @method      mixed source()
     *
     * @property    \Miaoxing\Source\Service\SourceLog $sourceLog
     * @method      mixed sourceLog()
     *
     * @property    \Miaoxing\Source\Service\SourceLogRecord $sourceLogRecord
     * @method      \Miaoxing\Source\Service\SourceLogRecord|\Miaoxing\Source\Service\SourceLogRecord[] sourceLogRecord()
     *
     * @property    \Miaoxing\Source\Service\SourceModel $sourceModel SourceModel
     * @method      \Miaoxing\Source\Service\SourceModel|\Miaoxing\Source\Service\SourceModel[] sourceModel()
     *
     * @property    \Miaoxing\Source\Service\SourceRecord $sourceRecord
     * @method      \Miaoxing\Source\Service\SourceRecord|\Miaoxing\Source\Service\SourceRecord[] sourceRecord()
     *
     * @property    \Miaoxing\Source\Service\SourceStat $sourceStat
     * @method      mixed sourceStat()
     *
     * @property    \Miaoxing\Source\Service\SourceStatRecord $sourceStatRecord
     * @method      \Miaoxing\Source\Service\SourceStatRecord|\Miaoxing\Source\Service\SourceStatRecord[] sourceStatRecord()
     *
     * @property    \Miaoxing\Source\Service\SourceWeeklyStat $sourceWeeklyStat
     * @method      mixed sourceWeeklyStat()
     *
     * @property    \Miaoxing\Source\Service\SourceWeeklyStatRecord $sourceWeeklyStatRecord
     * @method      \Miaoxing\Source\Service\SourceWeeklyStatRecord|\Miaoxing\Source\Service\SourceWeeklyStatRecord[] sourceWeeklyStatRecord()
     */
    class AutoComplete
    {
    }
}

namespace {

    /**
     * @return MiaoxingDoc\Source\AutoComplete
     */
    function wei()
    {
    }

    /** @var Miaoxing\Source\Service\Source $source */
    $source = wei()->source;

    /** @var Miaoxing\Source\Service\SourceLog $sourceLog */
    $sourceLog = wei()->sourceLog;

    /** @var Miaoxing\Source\Service\SourceLogRecord $sourceLogRecord */
    $sourceLogRecord = wei()->sourceLogRecord;

    /** @var Miaoxing\Source\Service\SourceModel $sourceModel */
    $source = wei()->sourceModel();

    /** @var Miaoxing\Source\Service\SourceModel|Miaoxing\Source\Service\SourceModel[] $sourceModels */
    $sources = wei()->sourceModel();

    /** @var Miaoxing\Source\Service\SourceRecord $sourceRecord */
    $sourceRecord = wei()->sourceRecord;

    /** @var Miaoxing\Source\Service\SourceStat $sourceStat */
    $sourceStat = wei()->sourceStat;

    /** @var Miaoxing\Source\Service\SourceStatRecord $sourceStatRecord */
    $sourceStatRecord = wei()->sourceStatRecord;

    /** @var Miaoxing\Source\Service\SourceWeeklyStat $sourceWeeklyStat */
    $sourceWeeklyStat = wei()->sourceWeeklyStat;

    /** @var Miaoxing\Source\Service\SourceWeeklyStatRecord $sourceWeeklyStatRecord */
    $sourceWeeklyStatRecord = wei()->sourceWeeklyStatRecord;
}
