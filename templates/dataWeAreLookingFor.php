<div class="container mt-4 mb-3">
    <h4 class="mb-4">Data we are looking for</h4>

    <div class="row mb-3">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Current (A)</h5>
                    <h6 class="card-subtitle mb-2 text-muted">E. g. <span class="decimal-figure">14.261</span></h6>
                    <p class="card-text">If represented as <span class="decimal-figure">14261</span> (<span class="math-figure">A * 1000 = mA</span>) (<span class="binary-figure">1110101001100000</span>), requires at least 16 bits (from <span class="decimal-figure">00000</span> to <span class="decimal-figure">60000</span>, at least; in pure binary representation without point).</p>
                    <p class="card-text"><small>Range in provided datasets goes from <span class="decimal-figure">0.001</span> to <span class="decimal-figure">21.000</span>, approximately.</small></p>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Active power (kW)</h5>
                    <h6 class="card-subtitle mb-2 text-muted">E. g. <span class="decimal-figure">1.249</span></h6>
                    <p class="card-text">If represented as <span class="decimal-figure">1249</span> (<span class="math-figure">kW * 1000 = W</span>) (<span class="binary-figure">10011100001</span>), requires at least 13 bits (from <span class="decimal-figure">0000</span> to <span class="decimal-figure">5000</span>, at least; in pure binary representation without point).</p>
                    <p class="card-text"><small>Range in provided datasets goes from <span class="decimal-figure">0.040</span> to <span class="decimal-figure">5.000</span>, approximately.</small></p>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Voltage (V)</h5>
                    <h6 class="card-subtitle mb-2 text-muted">E. g. <span class="decimal-figure">225.8</span></h6>
                    <p class="card-text">If represented as <span class="decimal-figure">2258</span> (<span class="math-figure">V * 10</span>) (<span class="binary-figure">100011010010</span>), requires at least 13 bits (from <span class="decimal-figure">0000</span> to <span class="decimal-figure">5000</span>, at least; in pure binary representation without point).</p>
                    <p class="card-text"><small>Allowed standard range in Spain goes from <span class="decimal-figure">213.9</span> to <span class="decimal-figure">246.1</span> (<span class="decimal-figure">230.0 ± 10 %</span>), but estimated real values go from <span class="decimal-figure">226.0</span> to <span class="decimal-figure">230.0</span>.</small></p>
                </div>
            </div>
        </div>
    </div>

    <p>Hint: <span class="math-figure">Active power (kW) * 1000 = Current (A) * Voltage (V)</span>.</p>
</div>