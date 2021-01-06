<?php

namespace App\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;

class CspPolicy extends \Spatie\Csp\Policies\Policy
{
    /**
     * @return void
     */
    public function configure()
    {
        $host = request()->getHost();
        $this->addDirective(Directive::BASE, [Keyword::SELF, $host])
            ->addDirective(Directive::CONNECT, [Keyword::SELF, $host])
            ->addDirective(Directive::FORM_ACTION, [Keyword::SELF, $host])
            ->addDirective(Directive::IMG, [Keyword::SELF, $host, 'data:'])
            ->addDirective(Directive::MEDIA, [Keyword::SELF, $host])
            ->addDirective(Directive::OBJECT, Keyword::NONE)
            ->addDirective(Directive::SCRIPT, [Keyword::SELF, $host])
            ->addDirective(Directive::SCRIPT, [Keyword::SELF, $host])
            ->addDirective(Directive::STYLE, [Keyword::SELF, $host])
            ->addNonceForDirective(Directive::STYLE)
            ->addNonceForDirective(Directive::SCRIPT);
    }
}
