<?php

namespace PandaZoom\LaravelEmailRule;

use PandaZoom\LaravelCustomRule\BaseCustomRule;
use function abs;
use function implode;

class Email extends BaseCustomRule
{
    protected ?int $min = 6;
    protected ?int $max = 100;

    protected bool $enableAllEmailRules = false;
    protected bool $enableEmailRuleRFC = false;
    protected bool $enableEmailRuleStrict = false;
    protected bool $enableEmailRuleDNS = false;
    protected bool $enableEmailRuleSpoof = false;
    protected bool $enableEmailRuleFilter = false;

    /**
     * Sets the minimum size of the email.
     *
     * @param int|null $size
     * @return static
     */
    public function min(?int $size): static
    {
        $this->min = $size === null ?: abs($size);

        return $this;
    }

    /**
     * Sets the minimum size of the email.
     *
     * @param int|null $size
     * @return static
     */
    public function max(?int $size): static
    {
        $this->max = $size === null ?: abs($size);

        return $this;
    }

    public function enableAllEmailRules(bool $enable = true): static
    {
        $this->enableAllEmailRules = $enable;

        return $this;
    }

    public function enableEmailRuleRFC(bool $enable = true): static
    {
        $this->enableEmailRuleRFC = $enable;

        return $this;
    }

    public function enableEmailRuleStrict(bool $enable = true): static
    {
        $this->enableEmailRuleStrict = $enable;

        return $this;
    }

    /**
     * @note The dns and spoof validators require the PHP intl extension.
     * @param bool $enable
     * @return static
     */
    public function enableEmailRuleDNS(bool $enable = true): static
    {
        $this->enableEmailRuleDNS = $enable;

        return $this;
    }

    /**
     * @note The dns and spoof validators require the PHP intl extension.
     * @param bool $enable
     * @return static
     */
    public function enableEmailRuleSpoof(bool $enable = true): static
    {
        $this->enableEmailRuleSpoof = $enable;

        return $this;
    }

    public function enableEmailRuleFilter(bool $enable = true): static
    {
        $this->enableEmailRuleFilter = $enable;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->messages = [];

        $rules = ['string'];

        if ($this->min) {
            $rules[] = 'min:' . $this->min;
        }

        if ($this->max) {
            $rules[] = 'max:' . $this->max;
        }

        $emailRules = [];

        if ($this->enableAllEmailRules || $this->enableEmailRuleRFC) {
            $emailRules[] = 'rfc';
        }

        if ($this->enableAllEmailRules || $this->enableEmailRuleStrict) {
            $emailRules[] = 'strict';
        }

        if ($this->enableAllEmailRules || $this->enableEmailRuleDNS) {
            $emailRules[] = 'dns';
        }

        if ($this->enableAllEmailRules || $this->enableEmailRuleSpoof) {
            $emailRules[] = 'spoof';
        }

        if ($this->enableAllEmailRules || $this->enableEmailRuleFilter) {
            $emailRules[] = 'filter';
        }

        if (!empty($emailRules)) {
            $rules[] = 'email:' . implode(',', $emailRules);
        } else {
            $rules[] = 'email';
        }

        $validator = $this->validate($attribute, $rules);

        if ($validator->fails()) {
            return $this->fail($validator->messages()->all());
        }

        return true;
    }
}
