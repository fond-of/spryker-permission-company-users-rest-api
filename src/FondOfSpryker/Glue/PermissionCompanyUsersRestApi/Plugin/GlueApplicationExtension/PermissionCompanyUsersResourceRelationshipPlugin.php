<?php

namespace FondOfSpryker\Glue\PermissionCompanyUsersRestApi\Plugin\GlueApplicationExtension;

use FondOfSpryker\Glue\PermissionCompanyUsersRestApi\PermissionCompanyUsersRestApiConfig;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRelationshipPluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfSpryker\Glue\PermissionCompanyUsersRestApi\PermissionCompanyUsersRestApiFactory getFactory()
 */
class PermissionCompanyUsersResourceRelationshipPlugin extends AbstractPlugin implements ResourceRelationshipPluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface[] $resources
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return void
     * @api
     *
     * {@inheritdoc}
     *
     */
    public function addResourceRelationships(array $resources, RestRequestInterface $restRequest): void
    {
        $this->getFactory()->createPermissionCompanyUsersResourceRelationshipExpander()
            ->addResourceRelationships($resources, $restRequest);
    }

    /**
     * @return string
     * @api
     *
     * {@inheritdoc}
     *
     */
    public function getRelationshipResourceType(): string
    {
        return PermissionCompanyUsersRestApiConfig::RESOURCE_PERMISSIONS;
    }
}
