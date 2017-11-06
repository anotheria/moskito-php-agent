<?php

namespace Anotheria\MoskitoPHPAgent\producers\builtin;

use Anotheria\MoskitoPHPAgent\MoskitoPHPConfig;

class BuiltinInitializer
{

    public static function initialize(MoskitoPHPConfig $config)
    {
        if($config->isBuiltinFeatureEnabled(MoskitoPHPConfig::FEATURE_EXECUTION_PRODUCER))
            self::initializeScriptExecutionProducer();
    }

    private static function initializeScriptExecutionProducer()
    {

        $executionProducer = new ExecutionProducer();

        $executionWatcher = $executionProducer->getExecutionWatcher();
        $executionWatcher->start();

        register_shutdown_function(function() use ($executionWatcher, $executionProducer) {
            $executionWatcher->end();
            $executionProducer->updateMemoryUsage();
        });

    }

}