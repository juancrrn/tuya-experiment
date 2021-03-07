<div class="container mt-4 mb-3">
    <h4 class="mb-3">About the following tables</h4>

    <div class="row mb-3 experiment-about-demo">
        <div class="col-md">
            <span class="std eqcol">1</span> (no color): the value never changes in the column.
        </div>
        <div class="col-md">
            <span class="std common">1</span> (green):
            <ul>
                <li><code>TE_HIGHLIGHT_MODE = true</code>: the value changes some time in the column.</li>
                <li><code>TE_HIGHLIGHT_MODE = false</code>: 0-valued bits.</li>
            </ul>
        </div>
        <div class="col-md">
            <span class="std diff">1</span> (purple):
            <ul>
                <li><code>TE_HIGHLIGHT_MODE = true</code>: the value is different to the one in the previous row.</li>
                <li><code>TE_HIGHLIGHT_MODE = false</code>: 1-valued bits.</li>
            </ul>
        </div>
    </div>

    <p>In the search experiment, the first field, <span class="global-demo-ijl">[row, start, length]</span>, specifies the row number, the start position and the binary string length for the search. In the statistics section, there is a sum of all the occurences in the same condicions.</p>
</div>