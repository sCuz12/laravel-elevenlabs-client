<?php
declare(strict_types=1);

namespace Georgehadjisavva\ElevenLabsClient\History;

interface HistoryInterface {
    public function getHistory();
    public function getHistoryItem(string $history_item_id);
    public function getHistoryItemAudio(string $history_item_id);
    public function deleteHistoryItem(string $history_item_id);
    public function downloadHistory(array $history_items, string $folderName);
}