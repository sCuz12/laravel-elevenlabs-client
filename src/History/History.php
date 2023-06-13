<?php

declare(strict_types=1);

namespace Georgehadjisavva\ElevenLabsClient\History;

use Exception;
use Georgehadjisavva\ElevenLabsClient\Interfaces\ElevenLabsClientInterface;
use Georgehadjisavva\ElevenLabsClient\Traits\ExceptionHandlerTrait;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Str;

class History implements HistoryInterface
{

    use ExceptionHandlerTrait;

    protected $client;

    public function __construct(ElevenLabsClientInterface $client)
    {
        $this->client = $client->getHttpClient();
    }

    /**
     * Returns metadata about all your generated audio.
     *
     * @return array The list of history.
     * 
     * See : https://docs.elevenlabs.io/api-reference/history
     */
    public function getHistory(): array
    {
        try {
            $response    = $this->client->get('history');
            $data        = $response->getBody()->getContents();
            $decodedData = json_decode($data, true);

            return $decodedData['history'] ?? [];
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Returns information about an history item by its ID.
     *
     * @return array The list of history.
     * 
     * See : https://docs.elevenlabs.io/api-reference/history-item-get
     */
    public function getHistoryItem(string $history_item_id) : array
    {
        try {
            $response = $this->client->get('history/'. $history_item_id);
            $data     = json_decode($response->getBody()->getContents(),true);

            return $data;

        } catch ( Exception $e){
            return $this->handleException($e);
        }
    }

    /**
     * Returns the audio of an history item.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The file download response.
     * 
     * See : https://docs.elevenlabs.io/api-reference/history-audio
     */
    public function getHistoryItemAudio(string $history_item_id, string $fileName)
    {
        try {
            $response = $this->client->get('history/'. $history_item_id . '/audio');

            $contentFile = $response->getBody()->getContents();
            $fileName    = $fileName . ".mp3";

            Storage::disk('public')->put($fileName , $contentFile);
            
            return response()->download(storage_path('app/public/' . $fileName), $fileName);

        } catch ( Exception $e){
            return $this->handleException($e);
        }
    }

     /**
     * Delete a history item by its ID
     *
     * @return array Status
     * 
     * See : https://docs.elevenlabs.io/api-reference/history-delete
     */
    public function deleteHistoryItem(string $history_item_id) :array
    {
        try {
            $response = $this->client->delete('history/'. $history_item_id);
            $data     = json_decode($response->getBody()->getContents(),true);

            return $data;

        } catch ( Exception $e){
            return $this->handleException($e);
        }
    }

    /**
     * Download one or more history items. If one history item ID is provided, we will return a single audio file.
     *  If more than one history item IDs are provided, we will provide the history items packed into a .zip file.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The file download response.
     * 
     * See : https://docs.elevenlabs.io/api-reference/history-download
     */
    public function downloadHistory(array $history_items, string $filename)
    {
        try {
            $extension = '.zip' ;

            $historyItems = [
                ...$history_items
            ];

            $bodyData = [
                'json' => [
                    'history_item_ids' => $historyItems
                ]
            ];
            
            // download mp3 if one items is given
            if(count($historyItems) <=1) {
                $extension = '.mp3';
            }
            
            $fileName    = $filename . $extension;
            $response    = $this->client->post('history/download',$bodyData);
            $fileContent = $response->getBody()->getContents();

           Storage::disk('public')->put($fileName , $fileContent);

           return response()->download(storage_path('app/public/' . $fileName), $fileName, [
                'Content-Type' => 'application/zip',
            ]);
            
        } catch ( Exception $e){
            return $this->handleException($e);
        }
    }
}
