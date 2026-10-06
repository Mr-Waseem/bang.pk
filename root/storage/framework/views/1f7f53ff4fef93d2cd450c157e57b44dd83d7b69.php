<?php
    $headerStrn = trim((string) (session()->get('company_strn') ?? ''));
    $headerNtn = trim((string) (session()->get('company_ntn') ?? ''));
    $headerAddress = trim((string) (session()->get('company_address') ?? ''));
    $headerLogo = trim((string) ($company->company_logo ?? ''));
    $hasLogo = $headerLogo !== '';
?>
<?php if($hasLogo): ?>
<table class="company-header company-header--logo">
    <tr>
        <td class="ch-info">
            <div class="ch-name"><?php echo e(session()->get('company_name')); ?></div>
            <?php if(filled($headerStrn) || filled($headerNtn)): ?>
            <div class="ch-meta">
                <?php if(filled($headerStrn)): ?>STRN: <?php echo e($headerStrn); ?><?php endif; ?>
                <?php if(filled($headerStrn) && filled($headerNtn)): ?> &emsp; <?php endif; ?>
                <?php if(filled($headerNtn)): ?>NTN: <?php echo e($headerNtn); ?><?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if(filled($headerAddress)): ?>
            <div class="ch-address"><?php echo e($headerAddress); ?></div>
            <?php endif; ?>
        </td>
        <td class="ch-logo">
            <img src="<?php echo e(asset($headerLogo)); ?>" alt="" onerror="this.style.display='none'">
        </td>
    </tr>
</table>
<?php else: ?>
<table class="company-header company-header--plain">
    <tr>
        <td class="ch-info">
            <div class="ch-name"><?php echo e(session()->get('company_name')); ?></div>
            <?php if(filled($headerStrn) || filled($headerNtn)): ?>
            <div class="ch-meta">
                <?php if(filled($headerStrn)): ?>STRN: <?php echo e($headerStrn); ?><?php endif; ?>
                <?php if(filled($headerStrn) && filled($headerNtn)): ?> &emsp; <?php endif; ?>
                <?php if(filled($headerNtn)): ?>NTN: <?php echo e($headerNtn); ?><?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if(filled($headerAddress)): ?>
            <address class="ch-address"><?php echo e($headerAddress); ?></address>
            <?php endif; ?>
        </td>
    </tr>
</table>
<?php endif; ?>
<?php /**PATH D:\Axis-Coding\xampp-8.2.12\htdocs\it_life_work\digital-invoicing\root\resources\views/include/company-header.blade.php ENDPATH**/ ?>