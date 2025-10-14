@once
  @vite('resources/css/components/pagination2.css')
@endonce

<!-- Container untuk kedua pagination berdampingan -->
<div class="pagination-container">
    <!-- Pagination Version 1 -->
    <div class="pagination-version1">
        <select id="itemsPerPage" class="items-per-page" onchange="changeItemsPerPage()">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>

    <!-- Pagination Version 2 -->
    <div class="pagination-version2">
        <!-- Tombol Prev -->
        <button class="pagination-btn prev-btn">Prev</button>
        
        <div class="page-numbers">
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <span class="ellipsis">...</span>
            <button class="page-btn">100</button>
        </div>

        <!-- Tombol Next -->
        <button class="pagination-btn next-btn">Next</button>
    </div>
</div>


