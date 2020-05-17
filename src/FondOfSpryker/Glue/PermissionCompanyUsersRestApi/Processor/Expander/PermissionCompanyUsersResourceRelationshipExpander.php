<?php

namespace FondOfSpryker\Glue\PermissionCompanyUsersRestApi\Processor\Expander;

use ArrayObject;
use FondOfSpryker\Glue\PermissionCompanyUsersRestApi\PermissionCompanyUsersRestApiConfig;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestPermissionsResponseAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class PermissionCompanyUsersResourceRelationshipExpander implements PermissionCompanyUsersResourceRelationshipExpanderInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     */
    public function __construct(RestResourceBuilderInterface $restResourceBuilder)
    {
        $this->restResourceBuilder = $restResourceBuilder;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface[] $resources
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return void
     */
    public function addResourceRelationships(array $resources, RestRequestInterface $restRequest): void
    {
        foreach ($resources as $resource) {
            $payload = $resource->getPayload();

            if ($payload === null || !($payload instanceof CompanyUserTransfer)) {
                continue;
            }

            $companyRoleCollectionTransfer = $payload->getCompanyRoleCollection();

            if ($companyRoleCollectionTransfer === null) {
                continue;
            }

            $roles = $companyRoleCollectionTransfer->getRoles();

            $permissions = $this->findPermissionsForCompanyUser($payload->getIdCompanyUser(), $roles);

            foreach ($permissions as $permissionTransfer) {
                $restPermissionsAttributesTransfer = (new RestPermissionsResponseAttributesTransfer())->fromArray(
                    $permissionTransfer->toArray(),
                    true
                );

                $companyUserPermissionsResource = $this->restResourceBuilder->createRestResource(
                    PermissionCompanyUsersRestApiConfig::RESOURCE_PERMISSIONS,
                    $permissionTransfer->getKey(),
                    $restPermissionsAttributesTransfer
                );

                $resource->addRelationship($companyUserPermissionsResource);
            }
        }
    }

    /**
     * @param int $idCompanyUser
     * @param \ArrayObject|\Generated\Shared\Transfer\CompanyRoleTransfer[] $roles
     *
     * @return \ArrayObject|\Generated\Shared\Transfer\PermissionTransfer[]
     */
    protected function findPermissionsForCompanyUser(int $idCompanyUser, ArrayObject $roles): ArrayObject
    {
        foreach ($roles as $roleTransfer) {
            $companyUserCollectionTransfer = $roleTransfer->getCompanyUserCollection();

            if ($companyUserCollectionTransfer === null) {
                continue;
            }

            $companyUserTransfers = $companyUserCollectionTransfer->getCompanyUsers();

            if (!$this->hasCompanyUserRole($idCompanyUser, $companyUserTransfers)) {
                continue;
            }

            $permissionCollection = $roleTransfer->getPermissionCollection();

            if ($permissionCollection === null) {
                continue;
            }

            return $permissionCollection->getPermissions();
        }

        return new ArrayObject();
    }

    /**
     * @param int $idCompanyUser
     * @param \ArrayObject|\Generated\Shared\Transfer\CompanyUserTransfer[] $rolesCompanyUsers
     *
     * @return bool
     */
    protected function hasCompanyUserRole(int $idCompanyUser, ArrayObject $rolesCompanyUsers): bool
    {
        foreach ($rolesCompanyUsers as $companyUserTransfer) {
            if ($companyUserTransfer->getIdCompanyUser() === $idCompanyUser) {
                return true;
            }
        }

        return false;
    }
}
