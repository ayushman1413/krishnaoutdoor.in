{{-- Layout rules shared by the Page Content list and editor. --}}
<style>
    .content-edit .cms-row { min-width: 0; }
    .content-edit .related-row > input { min-width: 0; }
    .content-edit-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; }

    @media (max-width: 640px) {
        .content-edit .related-row > button, .content-edit #related-add { width: 100%; }
        .content-edit #copy-link-target, .content-edit #related-pick { width: 100%; max-width: 100%; }
    }
</style>
