<?php


namespace booking\forms;


use booking\helpers\scr;
use yii\base\Model;
use yii\helpers\ArrayHelper;

abstract class CompositeForm extends Model
{
    private $forms = [];

    abstract protected function internalForms(): array;
    public function load($data, $formName = null)
    {
        $test = false;
        $success = parent::load($data, $formName);
        foreach ($this->forms as $name => $form) {
            if ($test) scr::_p($name);
            if (is_array($form)) {
                if (!empty($form)) {
                    if ($test) scr::_p($name);
                    if ($test) scr::_v($success);
                    $success = Model::loadMultiple($form, $data, $formName === null ? null : $name) && $success;
                    if ($test) scr::_v($success);
                } else {
                    $success = true && $success;
                }
            } else {
                if ($test) scr::_v($success);
                $success =  $form->load($data, $formName !== '' ? null : $name) && $success;
                if ($test) scr::_v($success);
            }
            if ($test) scr::_v($success);
        }
        if ($test) scr::_v($success);
        return $success;
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $parentNames = $attributeNames !== null ? array_filter((array)$attributeNames, 'is_string') : null;
        $success = parent::validate($parentNames, $clearErrors);
        foreach ($this->forms as $name => $form) {
            // scr::_p($name);

            if (is_array($form)) {
     //           scr::_v($success);
                $success = Model::validateMultiple($form) && $success;
     //           scr::_v($success);
            } else {
                $innerNames = $attributeNames !== null ? ArrayHelper::getValue($attributeNames, $name) : null;
                $success = $form->validate($innerNames ?: null, $clearErrors) && $success;
            }
        }
//        scr::v($success);
        return $success;
    }
    public function __get($name)
    {
        if (isset($this->forms[$name])) {
            return $this->forms[$name];
        }
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->internalForms(), true)) {
            $this->forms[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    public function __isset($name)
    {
        return isset($this->forms[$name]) || parent::__isset($name);
    }

    public function hasErrors($attribute = null): bool
    {
        if ($attribute !== null) {
            return parent::hasErrors($attribute);
        }
        if (parent::hasErrors($attribute)) {
            return true;
        }
        foreach ($this->forms as $name => $form) {
            if (is_array($form)) {
                foreach ($form as $i => $item) {
                    if ($item->hasErrors()) {
                        return true;
                    }
                }
            } else {
                if ($form->hasErrors()) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getFirstErrors(): array
    {
        $errors = parent::getFirstErrors();
        foreach ($this->forms as $name => $form) {
            if (is_array($form)) {
                foreach ($form as $i => $item) {
                    foreach ($item->getFirstErrors() as $attribute => $error) {
                        $errors[$name . '.' . $i . '.' . $attribute] = $error;
                    }
                }
            } else {
                foreach ($form->getFirstErrors() as $attribute => $error) {
                    $errors[$name . '.' . $attribute] = $error;
                }
            }
        }
        return $errors;
    }
}