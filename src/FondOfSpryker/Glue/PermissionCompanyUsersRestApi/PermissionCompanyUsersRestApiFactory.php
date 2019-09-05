<?php

namespace FondOfSpryker\Glue\PermissionCompanyUsersRestApi;

use FondOfSpryker\Glue\PermissionCompanyUsersRestApi\Processor\Expander\PermissionCompanyUsersResourceRelationshipExpander;
use FondOfSpryker\Glue\PermissionCompanyUsersRestApi\Processor\Expander\PermissionCompanyUsersResourceRelationshipExpanderInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class PermissionCompanyUsersRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Glue\PersmissionCompanyUsersRestApi\Processor\Expander\PermissionCompanyUsersResourceRelationshipExpanderInterface
     */
    public function createPermissionCompanyUsersResourceRelationshipExpander(): PermissionCompanyUsersResourceRelationshipExpanderInterface
    {
        return new PermissionCompanyUsersResourceRelationshipExpander(
            $this->getResourceBuilder()
        );
    }
}
