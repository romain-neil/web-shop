<?php

namespace App\Entity\Services;

interface SellableService {

	public function getPlan(): ?AbstractServicePlan;

	public function setPlan(?AbstractServicePlan $plan);

}
