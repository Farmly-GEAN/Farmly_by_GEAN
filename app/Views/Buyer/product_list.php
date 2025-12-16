<h1>Products</h1>
<ul class="grid">
  <?php foreach ($products as $p): ?>
    <li>
      <a href="/buyer/products/<?= htmlspecialchars((string)$p->id) ?>">
        <img src="<?= htmlspecialchars($p->image ?? '/assets/images/placeholder.png') ?>" alt="">
        <div><?= htmlspecialchars($p->name) ?></div>
        <div><?= number_format($p->price, 2) ?></div>
      </a>
    </li>
  <?php endforeach; ?>
</ul>
