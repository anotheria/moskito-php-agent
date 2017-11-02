<?php

namespace Ogmudebone\MoskitoPHP\producers\builtin;

class BuiltinInitializer
{

    public static function initialize()
    {
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