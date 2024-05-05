<?php
namespace User\V1\Rest\UserDocument;

class UserDocumentResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get(\User\Mapper\UserProfile::class);
        $userDocumentMapper = $services->get(\User\Mapper\UserDocument::class);
        $userDocumentService = $services->get(\User\V1\Service\UserDocument::class);
        $resource = new UserDocumentResource(
            $userProfileMapper,
            $userDocumentMapper,
        );
        $resource->setUserDocumentService($userDocumentService);
        return $resource;
    }
}
