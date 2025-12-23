<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use ReflectionMethod;
use Yii;
use yii\base\InlineAction;
use yii\base\InvalidConfigException;
use yii\web\Controller;

/**
 * Extends the foundational functionality of the Yii Controller allowing the usage of actions that don't require the
 * "action" prefix.
 */
abstract class CodicesController extends Controller {

    /**
     * @throws InvalidConfigException
     */
    public function createAction($id) {
        if ($id === '') {
            $id = $this->defaultAction;
        }

        $actionMap = $this->actions();
        if (isset($actionMap[$id])) {
            return Yii::createObject($actionMap[$id], [$id, $this]);
        }

        if (preg_match('/^(?:[a-z0-9_]+-)*[a-z0-9_]+$/', $id)) {
            $methodName = str_replace(' ', '', str_replace('-', ' ', $id));
            if (method_exists($this, $methodName)) {
                $method = new ReflectionMethod($this, $methodName);
                if ($method->isPublic() && $method->getName() === $methodName) {
                    return new InlineAction($id, $this, $methodName);
                }
            }
        }

        return null;
    }
}
