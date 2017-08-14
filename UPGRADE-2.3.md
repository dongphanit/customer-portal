UPGRADE FROM 2.2 to 2.3
========================

Table of Contents
-----------------

- [General](#general)
- [CommerceMenuBundle](#commercemenubundle)
- [CustomerBundle](#customerbundle)
- [FrontendBundle](#frontendbundle)

General
-------

### Important

The class `Oro\Bundle\SecurityBundle\SecurityFacade`, services `oro_security.security_facade` and `oro_security.security_facade.link`, and TWIG function `resource_granted` were marked as deprecated.
Use services `security.authorization_checker`, `security.token_storage`, `oro_security.token_accessor`, `oro_security.class_authorization_checker`, `oro_security.request_authorization_checker` and TWIG function `is_granted` instead.
In controllers use `isGranted` method from `Symfony\Bundle\FrameworkBundle\Controller\Controller`.
The usage of deprecated service `security.context` (interface `Symfony\Component\Security\Core\SecurityContextInterface`) was removed as well.
All existing classes were updated to use new services instead of the `SecurityFacade` and `SecurityContext`:

- service `security.authorization_checker`
    - implements `Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface`
    - the property name in classes that use this service is `authorizationChecker`
- service `security.token_storage`
    - implements `Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface`
    - the property name in classes that use this service is `tokenStorage`
- service `oro_security.token_accessor`
    - implements `Oro\Bundle\SecurityBundle\Authentication\TokenAccessorInterface`
    - the property name in classes that use this service is `tokenAccessor`
- service `oro_security.class_authorization_checker`
    - implements `Oro\Bundle\SecurityBundle\Authorization\ClassAuthorizationChecker`
    - the property name in classes that use this service is `classAuthorizationChecker`
- service `oro_security.request_authorization_checker`
    - implements `Oro\Bundle\SecurityBundle\Authorization\RequestAuthorizationChecker`
    - the property name in classes that use this service is `requestAuthorizationChecker`

CommerceMenuBundle
------------------
* The `LoggedInExpressionLanguageProvider::__construct(ServiceLink $securityFacadeLink)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CommerceMenuBundle/Menu/Condition/LoggedInExpressionLanguageProvider.php#L18 "Oro\Bundle\CommerceMenuBundle\Menu\Condition\LoggedInExpressionLanguageProvider")</sup> method was changed to `LoggedInExpressionLanguageProvider::__construct(TokenAccessorInterface $tokenAccessor)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CommerceMenuBundle/Menu/Condition/LoggedInExpressionLanguageProvider.php#L18 "Oro\Bundle\CommerceMenuBundle\Menu\Condition\LoggedInExpressionLanguageProvider")</sup>
* The `MenuConditionBuilder::__construct(ExpressionLanguage $expressionLanguage)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CommerceMenuBundle/Builder/MenuConditionBuilder.php#L22 "Oro\Bundle\CommerceMenuBundle\Builder\MenuConditionBuilder")</sup> method was changed to `MenuConditionBuilder::__construct(ExpressionLanguage $expressionLanguage, LoggerInterface $logger)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CommerceMenuBundle/Builder/MenuConditionBuilder.php#L29 "Oro\Bundle\CommerceMenuBundle\Builder\MenuConditionBuilder")</sup>

CustomerBundle
--------------
* The following classes were removed:
   - `AnonymousAuthenticationListener`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Security/Http/Firewall/AnonymousAuthenticationListener.php#L13 "Oro\Bundle\CustomerBundle\Security\Http\Firewall\AnonymousAuthenticationListener")</sup>
   - `AuditController`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Controller/AuditController.php#L12 "Oro\Bundle\CustomerBundle\Controller\AuditController")</sup>
* The `CustomerUserProvider::__construct(SecurityFacade $securityFacade, AclManager $aclManager)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Security/CustomerUserProvider.php#L43 "Oro\Bundle\CustomerBundle\Security\CustomerUserProvider")</sup> method was changed to `CustomerUserProvider::__construct(AuthorizationCheckerInterface $authorizationChecker, TokenAccessorInterface $tokenAccessor, AclManager $aclManager)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Security/CustomerUserProvider.php#L40 "Oro\Bundle\CustomerBundle\Security\CustomerUserProvider")</sup>
* The `PlaceholderFilter::__construct(SecurityFacade $securityFacade)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Placeholder/PlaceholderFilter.php#L18 "Oro\Bundle\CustomerBundle\Placeholder\PlaceholderFilter")</sup> method was changed to `PlaceholderFilter::__construct(TokenAccessorInterface $tokenAccessor)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Placeholder/PlaceholderFilter.php#L16 "Oro\Bundle\CustomerBundle\Placeholder\PlaceholderFilter")</sup>
* The `FrontendOwnerTreeProvider::__construct(ManagerRegistry $doctrine, DatabaseChecker $databaseChecker, CacheProvider $cache, MetadataProviderInterface $ownershipMetadataProvider, TokenStorageInterface $tokenStorage)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Owner/FrontendOwnerTreeProvider.php#L40 "Oro\Bundle\CustomerBundle\Owner\FrontendOwnerTreeProvider")</sup> method was changed to `FrontendOwnerTreeProvider::__construct(ManagerRegistry $doctrine, DatabaseChecker $databaseChecker, CacheProvider $cache, OwnershipMetadataProviderInterface $ownershipMetadataProvider, TokenStorageInterface $tokenStorage)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Owner/FrontendOwnerTreeProvider.php#L39 "Oro\Bundle\CustomerBundle\Owner\FrontendOwnerTreeProvider")</sup>
* The `SignInProvider::__construct(RequestStack $requestStack, SecurityFacade $securityFacade, CsrfTokenManagerInterface $csrfTokenManager)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Layout/DataProvider/SignInProvider.php#L38 "Oro\Bundle\CustomerBundle\Layout\DataProvider\SignInProvider")</sup> method was changed to `SignInProvider::__construct(RequestStack $requestStack, TokenAccessorInterface $tokenAccessor, CsrfTokenManagerInterface $csrfTokenManager)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Layout/DataProvider/SignInProvider.php#L32 "Oro\Bundle\CustomerBundle\Layout\DataProvider\SignInProvider")</sup>
* The `UserDeleteHandler::__construct(SecurityFacade $securityFacade)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Handler/UserDeleteHandler.php#L19 "Oro\Bundle\CustomerBundle\Handler\UserDeleteHandler")</sup> method was changed to `UserDeleteHandler::__construct(TokenAccessorInterface $tokenAccessor)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Handler/UserDeleteHandler.php#L19 "Oro\Bundle\CustomerBundle\Handler\UserDeleteHandler")</sup>
* The `CustomerType::__construct(EventDispatcherInterface $eventDispatcher)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Form/Type/CustomerType.php#L40 "Oro\Bundle\CustomerBundle\Form\Type\CustomerType")</sup> method was changed to `CustomerType::__construct(EventDispatcherInterface $eventDispatcher, AuthorizationCheckerInterface $authorizationChecker)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Form/Type/CustomerType.php#L45 "Oro\Bundle\CustomerBundle\Form\Type\CustomerType")</sup>
* The `CustomerUserType::__construct(SecurityFacade $securityFacade)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Form/Type/CustomerUserType.php#L39 "Oro\Bundle\CustomerBundle\Form\Type\CustomerUserType")</sup> method was changed to `CustomerUserType::__construct(AuthorizationCheckerInterface $authorizationChecker, TokenAccessorInterface $tokenAccessor)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Form/Type/CustomerUserType.php#L38 "Oro\Bundle\CustomerBundle\Form\Type\CustomerUserType")</sup>
* The `FrontendCustomerUserRoleSelectType::__construct(SecurityFacade $securityFacade, Registry $registry, AclHelper $aclHelper)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Form/Type/FrontendCustomerUserRoleSelectType.php#L41 "Oro\Bundle\CustomerBundle\Form\Type\FrontendCustomerUserRoleSelectType")</sup> method was changed to `FrontendCustomerUserRoleSelectType::__construct(TokenAccessorInterface $tokenAccessor, ManagerRegistry $registry, AclHelper $aclHelper)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Form/Type/FrontendCustomerUserRoleSelectType.php#L38 "Oro\Bundle\CustomerBundle\Form\Type\FrontendCustomerUserRoleSelectType")</sup>
* The `FrontendCustomerUserType::__construct(SecurityFacade $securityFacade)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Form/Type/FrontendCustomerUserType.php#L31 "Oro\Bundle\CustomerBundle\Form\Type\FrontendCustomerUserType")</sup> method was changed to `FrontendCustomerUserType::__construct(AuthorizationCheckerInterface $authorizationChecker, TokenAccessorInterface $tokenAccessor)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Form/Type/FrontendCustomerUserType.php#L32 "Oro\Bundle\CustomerBundle\Form\Type\FrontendCustomerUserType")</sup>
* The `AbstractCustomerUserRoleHandler::setChainMetadataProvider(ChainMetadataProvider $chainMetadataProvider)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Form/Handler/AbstractCustomerUserRoleHandler.php#L65 "Oro\Bundle\CustomerBundle\Form\Handler\AbstractCustomerUserRoleHandler")</sup> method was changed to `AbstractCustomerUserRoleHandler::setChainMetadataProvider(ChainOwnershipMetadataProvider $chainMetadataProvider)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Form/Handler/AbstractCustomerUserRoleHandler.php#L65 "Oro\Bundle\CustomerBundle\Form\Handler\AbstractCustomerUserRoleHandler")</sup>
* The `CustomerUserHandler::__construct(FormInterface $form, Request $request, CustomerUserManager $userManager, SecurityFacade $securityFacade, TranslatorInterface $translator, LoggerInterface $logger)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Form/Handler/CustomerUserHandler.php#L45 "Oro\Bundle\CustomerBundle\Form\Handler\CustomerUserHandler")</sup> method was changed to `CustomerUserHandler::__construct(FormInterface $form, Request $request, CustomerUserManager $userManager, TokenAccessorInterface $tokenAccessor, TranslatorInterface $translator, LoggerInterface $logger)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Form/Handler/CustomerUserHandler.php#L44 "Oro\Bundle\CustomerBundle\Form\Handler\CustomerUserHandler")</sup>
* The `NavigationListener::__construct(SecurityFacade $securityFacade)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/EventListener/NavigationListener.php#L22 "Oro\Bundle\CustomerBundle\EventListener\NavigationListener")</sup> method was changed to `NavigationListener::__construct(AuthorizationCheckerInterface $authorizationChecker)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/EventListener/NavigationListener.php#L23 "Oro\Bundle\CustomerBundle\EventListener\NavigationListener")</sup>
* The `OrmDatasourceAclListener::__construct(SecurityFacade $securityFacade, MetadataProviderInterface $metadataProvider)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/EventListener/OrmDatasourceAclListener.php#L31 "Oro\Bundle\CustomerBundle\EventListener\OrmDatasourceAclListener")</sup> method was changed to `OrmDatasourceAclListener::__construct(TokenAccessorInterface $tokenAccessor, OwnershipMetadataProviderInterface $metadataProvider)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/EventListener/OrmDatasourceAclListener.php#L27 "Oro\Bundle\CustomerBundle\EventListener\OrmDatasourceAclListener")</sup>
* The `RecordOwnerDataListener::__construct(ServiceLink $securityContextLink, ConfigProvider $configProvider)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/EventListener/RecordOwnerDataListener.php#L28 "Oro\Bundle\CustomerBundle\EventListener\RecordOwnerDataListener")</sup> method was changed to `RecordOwnerDataListener::__construct(TokenStorageInterface $tokenStorage, ConfigProvider $configProvider)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/EventListener/RecordOwnerDataListener.php#L27 "Oro\Bundle\CustomerBundle\EventListener\RecordOwnerDataListener")</sup>
* The `GridViewManagerComposite::__construct(GridViewManager $defaultGridViewManager, GridViewManager $frontendGridViewManager, SecurityFacade $securityFacade)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Entity/Manager/GridViewManagerComposite.php#L28 "Oro\Bundle\CustomerBundle\Entity\Manager\GridViewManagerComposite")</sup> method was changed to `GridViewManagerComposite::__construct(GridViewManager $defaultGridViewManager, GridViewManager $frontendGridViewManager, TokenAccessorInterface $tokenAccessor)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Entity/Manager/GridViewManagerComposite.php#L28 "Oro\Bundle\CustomerBundle\Entity\Manager\GridViewManagerComposite")</sup>
* The `ActionPermissionProvider::__construct(SecurityFacade $securityFacade)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Datagrid/ActionPermissionProvider.php#L17 "Oro\Bundle\CustomerBundle\Datagrid\ActionPermissionProvider")</sup> method was changed to `ActionPermissionProvider::__construct(AuthorizationCheckerInterface $authorizationChecker, TokenAccessorInterface $tokenAccessor)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Datagrid/ActionPermissionProvider.php#L23 "Oro\Bundle\CustomerBundle\Datagrid\ActionPermissionProvider")</sup>
* The `CustomerActionPermissionProvider::__construct(SecurityFacade $securityFacade, Registry $doctrine)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Datagrid/CustomerActionPermissionProvider.php#L26 "Oro\Bundle\CustomerBundle\Datagrid\CustomerActionPermissionProvider")</sup> method was changed to `CustomerActionPermissionProvider::__construct(AuthorizationCheckerInterface $authorizationChecker, ManagerRegistry $doctrine)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Datagrid/CustomerActionPermissionProvider.php#L23 "Oro\Bundle\CustomerBundle\Datagrid\CustomerActionPermissionProvider")</sup>
* The `GridViewsExtensionComposite::__construct(GridViewsExtension $defaultGridViewsExtension, GridViewsExtension $frontendGridViewsExtension, SecurityFacade $securityFacade)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Datagrid/Extension/GridViewsExtensionComposite.php#L28 "Oro\Bundle\CustomerBundle\Datagrid\Extension\GridViewsExtensionComposite")</sup> method was changed to `GridViewsExtensionComposite::__construct(GridViewsExtension $defaultGridViewsExtension, GridViewsExtension $frontendGridViewsExtension, TokenAccessorInterface $tokenAccessor)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Datagrid/Extension/GridViewsExtensionComposite.php#L28 "Oro\Bundle\CustomerBundle\Datagrid\Extension\GridViewsExtensionComposite")</sup>
* The `RoleTranslationPrefixResolver::__construct(SecurityFacade $securityFacade)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Acl/Resolver/RoleTranslationPrefixResolver.php#L22 "Oro\Bundle\CustomerBundle\Acl\Resolver\RoleTranslationPrefixResolver")</sup> method was changed to `RoleTranslationPrefixResolver::__construct(TokenAccessorInterface $tokenAccessor)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Acl/Resolver/RoleTranslationPrefixResolver.php#L20 "Oro\Bundle\CustomerBundle\Acl\Resolver\RoleTranslationPrefixResolver")</sup>
* The `CustomerUserProvider::$securityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Security/CustomerUserProvider.php#L22 "Oro\Bundle\CustomerBundle\Security\CustomerUserProvider::$securityFacade")</sup> property was removed.
* The `ScopeCustomerGroupCriteriaProvider::$propertyAccessor`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Provider/ScopeCustomerGroupCriteriaProvider.php#L24 "Oro\Bundle\CustomerBundle\Provider\ScopeCustomerGroupCriteriaProvider::$propertyAccessor")</sup> property was removed.
* The `PlaceholderFilter::$securityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Placeholder/PlaceholderFilter.php#L13 "Oro\Bundle\CustomerBundle\Placeholder\PlaceholderFilter::$securityFacade")</sup> property was removed.
* The following properties in class `FrontendOwnershipMetadataProvider`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Owner/Metadata/FrontendOwnershipMetadataProvider.php#L21 "Oro\Bundle\CustomerBundle\Owner\Metadata\FrontendOwnershipMetadataProvider")</sup> were removed:
   - `$localLevelClass::$localLevelClass`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Owner/Metadata/FrontendOwnershipMetadataProvider.php#L21 "Oro\Bundle\CustomerBundle\Owner\Metadata\FrontendOwnershipMetadataProvider::$localLevelClass")</sup>
   - `$basicLevelClass::$basicLevelClass`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Owner/Metadata/FrontendOwnershipMetadataProvider.php#L26 "Oro\Bundle\CustomerBundle\Owner\Metadata\FrontendOwnershipMetadataProvider::$basicLevelClass")</sup>
* The `SignInProvider::$securityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Layout/DataProvider/SignInProvider.php#L26 "Oro\Bundle\CustomerBundle\Layout\DataProvider\SignInProvider::$securityFacade")</sup> property was removed.
* The `UserDeleteHandler::$securityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Handler/UserDeleteHandler.php#L14 "Oro\Bundle\CustomerBundle\Handler\UserDeleteHandler::$securityFacade")</sup> property was removed.
* The `CustomerUserType::$securityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Form/Type/CustomerUserType.php#L34 "Oro\Bundle\CustomerBundle\Form\Type\CustomerUserType::$securityFacade")</sup> property was removed.
* The `FrontendCustomerUserRoleSelectType::$securityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Form/Type/FrontendCustomerUserRoleSelectType.php#L23 "Oro\Bundle\CustomerBundle\Form\Type\FrontendCustomerUserRoleSelectType::$securityFacade")</sup> property was removed.
* The `FrontendCustomerUserType::$securityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Form/Type/FrontendCustomerUserType.php#L21 "Oro\Bundle\CustomerBundle\Form\Type\FrontendCustomerUserType::$securityFacade")</sup> property was removed.
* The `CustomerUserHandler::$securityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Form/Handler/CustomerUserHandler.php#L29 "Oro\Bundle\CustomerBundle\Form\Handler\CustomerUserHandler::$securityFacade")</sup> property was removed.
* The `OrmDatasourceAclListener::$securityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/EventListener/OrmDatasourceAclListener.php#L20 "Oro\Bundle\CustomerBundle\EventListener\OrmDatasourceAclListener::$securityFacade")</sup> property was removed.
* The `RecordOwnerDataListener::$securityContextLink`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/EventListener/RecordOwnerDataListener.php#L19 "Oro\Bundle\CustomerBundle\EventListener\RecordOwnerDataListener::$securityContextLink")</sup> property was removed.
* The `GridViewManagerComposite::$securityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Entity/Manager/GridViewManagerComposite.php#L21 "Oro\Bundle\CustomerBundle\Entity\Manager\GridViewManagerComposite::$securityFacade")</sup> property was removed.
* The `ActionPermissionProvider::$securityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Datagrid/ActionPermissionProvider.php#L12 "Oro\Bundle\CustomerBundle\Datagrid\ActionPermissionProvider::$securityFacade")</sup> property was removed.
* The `CustomerActionPermissionProvider::$securityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Datagrid/CustomerActionPermissionProvider.php#L15 "Oro\Bundle\CustomerBundle\Datagrid\CustomerActionPermissionProvider::$securityFacade")</sup> property was removed.
* The `CustomerUserExtension::$container`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Datagrid/Extension/CustomerUserExtension.php#L18 "Oro\Bundle\CustomerBundle\Datagrid\Extension\CustomerUserExtension::$container")</sup> property was removed.
* The `GridViewsExtensionComposite::$securityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Datagrid/Extension/GridViewsExtensionComposite.php#L21 "Oro\Bundle\CustomerBundle\Datagrid\Extension\GridViewsExtensionComposite::$securityFacade")</sup> property was removed.
* The `RoleTranslationPrefixResolver::$securityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Acl/Resolver/RoleTranslationPrefixResolver.php#L17 "Oro\Bundle\CustomerBundle\Acl\Resolver\RoleTranslationPrefixResolver::$securityFacade")</sup> property was removed.
* The `FrontendOwnerTreeProvider::fillTree(OwnerTreeInterface $tree)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Owner/FrontendOwnerTreeProvider.php#L69 "Oro\Bundle\CustomerBundle\Owner\FrontendOwnerTreeProvider")</sup> method was changed to `FrontendOwnerTreeProvider::fillTree(OwnerTreeBuilderInterface $tree)`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.3.0/src/Oro/Bundle/CustomerBundle/Owner/FrontendOwnerTreeProvider.php#L68 "Oro\Bundle\CustomerBundle\Owner\FrontendOwnerTreeProvider")</sup>
* The following methods in class `FrontendOwnershipMetadata`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Owner/Metadata/FrontendOwnershipMetadata.php#L19 "Oro\Bundle\CustomerBundle\Owner\Metadata\FrontendOwnershipMetadata")</sup> were removed:
   - `isLocalLevelOwned::isLocalLevelOwned`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Owner/Metadata/FrontendOwnershipMetadata.php#L19 "Oro\Bundle\CustomerBundle\Owner\Metadata\FrontendOwnershipMetadata::isLocalLevelOwned")</sup>
   - `isBasicLevelOwned::isBasicLevelOwned`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Owner/Metadata/FrontendOwnershipMetadata.php#L27 "Oro\Bundle\CustomerBundle\Owner\Metadata\FrontendOwnershipMetadata::isBasicLevelOwned")</sup>
   - `isGlobalLevelOwned::isGlobalLevelOwned`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Owner/Metadata/FrontendOwnershipMetadata.php#L35 "Oro\Bundle\CustomerBundle\Owner\Metadata\FrontendOwnershipMetadata::isGlobalLevelOwned")</sup>
* The `CustomerUserExtension::setContainer`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Datagrid/Extension/CustomerUserExtension.php#L23 "Oro\Bundle\CustomerBundle\Datagrid\Extension\CustomerUserExtension::setContainer")</sup> method was removed.
* The following methods in class `FrontendOwnershipMetadataProvider`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Owner/Metadata/FrontendOwnershipMetadataProvider.php#L46 "Oro\Bundle\CustomerBundle\Owner\Metadata\FrontendOwnershipMetadataProvider")</sup> were removed:
   - `setAccessLevelClasses::setAccessLevelClasses`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Owner/Metadata/FrontendOwnershipMetadataProvider.php#L46 "Oro\Bundle\CustomerBundle\Owner\Metadata\FrontendOwnershipMetadataProvider::setAccessLevelClasses")</sup>
   - `getSecurityConfigProvider::getSecurityConfigProvider`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Owner/Metadata/FrontendOwnershipMetadataProvider.php#L61 "Oro\Bundle\CustomerBundle\Owner\Metadata\FrontendOwnershipMetadataProvider::getSecurityConfigProvider")</sup>
* The `RecordOwnerDataListener::getSecurityContext`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/EventListener/RecordOwnerDataListener.php#L81 "Oro\Bundle\CustomerBundle\EventListener\RecordOwnerDataListener::getSecurityContext")</sup> method was removed.
* The `CustomerUserRoleController::getSecurityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Controller/Frontend/CustomerUserRoleController.php#L153 "Oro\Bundle\CustomerBundle\Controller\Frontend\CustomerUserRoleController::getSecurityFacade")</sup> method was removed.
* The `CustomerUserRoleVoter::getSecurityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Acl/Voter/CustomerUserRoleVoter.php#L134 "Oro\Bundle\CustomerBundle\Acl\Voter\CustomerUserRoleVoter::getSecurityFacade")</sup> method was removed.
* The `CustomerVoter::getSecurityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Acl/Voter/CustomerVoter.php#L283 "Oro\Bundle\CustomerBundle\Acl\Voter\CustomerVoter::getSecurityFacade")</sup> method was removed.
* The `AclGroupProvider::getSecurityFacade`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/CustomerBundle/Acl/Group/AclGroupProvider.php#L37 "Oro\Bundle\CustomerBundle\Acl\Group\AclGroupProvider::getSecurityFacade")</sup> method was removed.
* Class `Oro\Bundle\CustomerBundle\EventListener\RecordOwnerDataListener`
    - constant `OWNER_TYPE_ACCOUNT` was renamed to `OWNER_TYPE_CUSTOMER`
* The DI container parameter `oro_customer.entity.owners` was changed
    - the option `local_level` was renamed to `business_unit`
    - the option `basic_level` was renamed to `user`

FrontendBundle
--------------
* The `OroFrontendExtension::addPhoneToAddress`<sup>[[?]](https://github.com/oroinc/customer-portal/tree/2.2.0/src/Oro/Bundle/FrontendBundle/DependencyInjection/OroFrontendExtension.php#L79 "Oro\Bundle\FrontendBundle\DependencyInjection\OroFrontendExtension::addPhoneToAddress")</sup> method was removed.
