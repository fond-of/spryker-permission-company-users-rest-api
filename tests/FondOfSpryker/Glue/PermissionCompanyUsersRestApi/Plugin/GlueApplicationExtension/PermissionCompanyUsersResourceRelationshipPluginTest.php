<?php

namespace FondOfSpryker\Glue\PermissionCompanyUsersRestApi\Plugin\GlueApplicationExtension;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\PermissionCompanyUsersRestApi\PermissionCompanyUsersRestApiConfig;
use FondOfSpryker\Glue\PermissionCompanyUsersRestApi\PermissionCompanyUsersRestApiFactory;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class PermissionCompanyUsersResourceRelationshipPluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\PermissionCompanyUsersRestApi\Plugin\GlueApplicationExtension\PermissionCompanyUsersResourceRelationshipPlugin
     */
    protected $permissionCompanyUsersResourceRelationshipPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestInterfaceMock;

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface[]
     */
    protected $resources;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\PermissionCompanyUsersRestApi\PermissionCompanyUsersRestApiFactory
     */
    protected $permissionCompanyUsersRestApiFactoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->resources = [];

        $this->restRequestInterfaceMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionCompanyUsersRestApiFactoryMock = $this->getMockBuilder(PermissionCompanyUsersRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionCompanyUsersResourceRelationshipPlugin = new PermissionCompanyUsersResourceRelationshipPlugin();
        $this->permissionCompanyUsersResourceRelationshipPlugin->setFactory($this->permissionCompanyUsersRestApiFactoryMock);
    }

    /**
     * @return void
     */
    public function testAddResourceRelationships(): void
    {
        $this->permissionCompanyUsersResourceRelationshipPlugin->addResourceRelationships(
            $this->resources,
            $this->restRequestInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testGetRelationshipResourceType(): void
    {
        $this->assertSame(
            PermissionCompanyUsersRestApiConfig::RESOURCE_PERMISSIONS,
            $this->permissionCompanyUsersResourceRelationshipPlugin->getRelationshipResourceType()
        );
    }
}
