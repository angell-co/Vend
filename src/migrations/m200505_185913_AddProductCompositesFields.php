<?php

namespace angellco\vend\migrations;

use Craft;
use craft\base\Field;
use craft\db\Migration;
use craft\db\Query;
use craft\db\Table;
use craft\fields\Date;
use craft\fields\PlainText;

/**
 * m200505_185913_AddProductCompositesField migration.
 */
class m200505_185913_AddProductCompositesFields extends Migration
{
    /**
     * @inheritdoc
     *
     * @return bool|void
     * @throws \Throwable
     */
    public function safeUp()
    {
        $fieldsService = Craft::$app->getFields();

        if (!$fieldsService->getFieldByHandle('vendCompositeChildProducts')) {
            $fieldGroupId = (new Query())
                ->select([
                    'id',
                    'name',
                ])
                ->where(['name' => 'Vend'])
                ->from([Table::FIELDGROUPS])
                ->scalar();

            $field = $fieldsService->createField([
                'type' => PlainText::class,
                'groupId' => $fieldGroupId,
                'name' => 'Vend Composite Child Products',
                'handle' => 'vendCompositeChildProducts',
                'instructions' => '',
                'searchable' => true,
                'translationMethod' => Field::TRANSLATION_METHOD_NONE,
                'translationKeyFormat' => '',
                'settings' => [
                    'code' => true,
                    'multiline' => true,
                ],
            ]);

            $fieldsService->saveField($field);
        }

        if (!$fieldsService->getFieldByHandle('vendCompositeParentProductIds')) {
            $fieldGroupId = (new Query())
                ->select([
                    'id',
                    'name',
                ])
                ->where(['name' => 'Vend'])
                ->from([Table::FIELDGROUPS])
                ->scalar();

            $field = $fieldsService->createField([
                'type' => PlainText::class,
                'groupId' => $fieldGroupId,
                'name' => 'Vend Composite Parent Product IDs',
                'handle' => 'vendCompositeParentProductIds',
                'instructions' => '',
                'searchable' => true,
                'translationMethod' => Field::TRANSLATION_METHOD_NONE,
                'translationKeyFormat' => '',
                'settings' => [
                    'code' => true,
                    'multiline' => true,
                ],
            ]);

            $fieldsService->saveField($field);
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m200505_185913_AddProductCompositesField cannot be reverted.\n";
        return false;
    }
}
