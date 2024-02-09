<div x-data="{showFlash: true}">
    <?php if (session()->hasFlash('success')) : ?>
        <template x-if="showFlash">
            <p class="px-4 py-2 rounded-md bg-green-50 border border-green-100 z-10 text-green-600 absolute w-max top-20 inset-x-0 mx-auto"><?= session()->getFlash('success') ?></p>
        </template>
    <?php endif ?>
    <?php if (session()->hasFlash('error')) : ?>
        <template x-if="showFlash">
            <p class="px-4 py-2 rounded-md bg-rose-50 border border-rose-100 z-10 text-rose-600 absolute w-max top-20 inset-x-0 mx-auto"><?= session()->getFlash('error') ?></p>
        </template>
    <?php endif ?>
    <span x-init="setTimeout(() => (showFlash = false), 5000)"></span>
</div>