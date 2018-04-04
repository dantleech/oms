<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Oms\Business\OrderStateMachine;

use Spryker\Zed\Oms\Business\Exception\StateNotFoundException;

class FlagReader implements FlagReaderInterface
{
    /**
     * @var \Spryker\Zed\Oms\Business\OrderStateMachine\BuilderInterface
     */
    protected $builder;

    /**
     * @param \Spryker\Zed\Oms\Business\OrderStateMachine\BuilderInterface $builder
     */
    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param string $processName
     * @param string $stateName
     *
     * @throws \Spryker\Zed\Oms\Business\Exception\StateNotFoundException
     *
     * @return string[]
     */
    public function getStateFlags($processName, $stateName)
    {
        $process = $this->builder->createProcess($processName);

        $allStates = $process->getAllStates();
        if (!isset($allStates[$stateName])) {
            throw new StateNotFoundException(sprintf(
                sprintf(
                    'State with name "%s" not found in %s Order state machine process',
                    $stateName,
                    $processName
                )
            ));
        }

        $state = $allStates[$stateName];

        return $state->getFlags();
    }
}
