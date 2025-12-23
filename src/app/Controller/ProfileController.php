<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Model\Account;
use Codices\View\Facade\ProfileForm;
use Yii;
use yii\web\Response;

final class ProfileController extends CodicesController {

    public function view(): Response|string {
        $id = Yii::$app->user->id;
        $account = Account::findOne(['id' => $id]);
        if ($account === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }

        return $this->render('view', [
            'account' => $account,
        ]);
    }

    public function edit(): Response|string {
        $id = Yii::$app->user->id;
        $account = Account::findOne(['id' => $id]);
        if ($account === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }

        $form = new ProfileForm();
        $form->loadFromAccount($account);

        $request = Yii::$app->request;
        if ($request->isPost) {
            $form->setAttributes($request->post());
            if ($form->validate()) {
                $form->applyToAccount($account);
                if ($account->save()) {
                    return $this->redirect(['/profile/view']);
                }
            }
        }

        return $this->render('edit', [
            'model' => $form
        ]);
    }
}
