<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;

class GoogleDriveService
{
  protected $service;

  public function __construct()
  {
    $client = new Client();
    $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
    $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));

    $this->service = new Drive($client);
  }

  public function uploadFile($path, $name, $parentId = null)
  {
    $fileMetaData = [
      'name' => $name,
      'parents' => $parentId ? [$parentId] : [],
    ];

    $content = file_get_contents($path);

    $file = new Drive\DriveFile($fileMetaData);

    return $this->service->files->create($file, [
      'data' => $content,
      'uploadType' => 'multipart',
      'fields' => 'id, webViewLink, webContentLink',
    ]);
  }

  public function getFolderByName($name, $parentId = null)
  {
    $query = "mimeType='application/vnd.google-apps.folder' and name='$name' and trashed=false";

    if ($parentId) {
      $query .= " and '$parentId' in parents";
    }

    $result = $this->service->files->listFiles([
      'q' => $query,
      'fields' => 'files(id, name)'
    ]);

    if (count($result->files) > 0) {
      return $result->files[0];
    }

    return null;
  }

  public function createFolder($folderName, $parentId = null)
  {
    $folderMetadata = new Drive\DriveFile([
      'name'   => $folderName,
      'mimeType' => 'application/vnd.google-apps.folder',
      'parents'  => $parentId ? [$parentId] : []
    ]);

    return $this->service->files->create($folderMetadata, [
      'fields' => 'id, name'
    ]);
  }

  public function setPublicPermission($fileId)
  {
      $permission = new Drive\Permission();
      $permission->setType('domain');
      $permission->setDomain('tsu.ac.id');
      $permission->setRole('reader');

      return $this->service->permissions->create($fileId, $permission);
  }
}
