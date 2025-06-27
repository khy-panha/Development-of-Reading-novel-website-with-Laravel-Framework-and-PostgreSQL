<?php

function getAuthorApprovalMode() {
    return \App\Models\Setting::where('key', 'author_approval_mode')->value('value') ?? 'manual';
}