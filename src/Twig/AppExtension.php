<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension {


	public function getFunctions(): array {
		return [
			new TwigFunction('panel_url', [$this, 'servicePanelHomeUrl'])
		];
	}

	public function servicePanelHomeUrl(string $serviceType): string {
		return "panel_" . $serviceType . '_show';
	}

}
