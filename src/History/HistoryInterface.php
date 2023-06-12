<?php
declare(strict_types=1);

interface HistoryInterface {
    public function getHistory();
    public function getHistoryItem();
    public function getHistoryItemAudi();
    public function deleteHistoryItem();
    public function downloadHistory();
}