<div class="flex justify-center gap-2 my-8">
    <?php if ($pagination['has_previous']): ?>
        <button type="button" data-page="<?= $page - 1 ?>"
            class="pagination-btn px-4 py-2 text-white rounded-md hover:bg-[#1f1f1f] border border-[#2e2e2e]">
            Previous
        </button>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
        <button type="button" data-page="<?= $i ?>"
            class="pagination-btn px-4 py-2 text-white rounded-md <?= $i === $page ? 'bg-[#1f1f1f]' : 'hover:bg-[#1f1f1f]' ?> border border-[#2e2e2e]">
            <?= $i ?>
        </button>
    <?php endfor; ?>

    <?php if ($pagination['has_next']): ?>
        <button type="button" data-page="<?= $page + 1 ?>"
            class="pagination-btn px-4 py-2 text-white rounded-md hover:bg-[#1f1f1f] border border-[#2e2e2e]">
            Next
        </button>
    <?php endif; ?>
</div>