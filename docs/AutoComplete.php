<?php

namespace plugins\source\docs {

    use Miaoxing\Source\Service\Source;
    use Miaoxing\Source\Service\SourceLog;
    use Miaoxing\Source\Service\SourceLogRecord;
    use Miaoxing\Source\Service\SourceRecord;
    use Miaoxing\Source\Service\SourceWeeklyStat;
    use Miaoxing\Source\Service\SourceWeeklyStatRecord;

    /**
     * @property    Source $source 来源服务
     * @method      SourceRecord|SourceRecord[] source()
     *
     * @property    SourceLog $sourceLog 来源日志
     * @method      SourceLogRecord|SourceLogRecord[] sourceLog()
     *
     * @property    SourceWeeklyStat $sourceWeeklyStat 来源日志
     * @method      SourceWeeklyStatRecord|SourceWeeklyStatRecord[] sourceWeeklyStat()
     */
    class AutoComplete
    {
    }
}

namespace {

    /**
     * @return \plugins\source\docs\AutoComplete
     */
    function wei()
    {
    }
}
