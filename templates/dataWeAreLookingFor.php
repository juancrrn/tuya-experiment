<h4>Data we are looking for</h4>

<ul>
    <li>
        Current (A):
        <ul>
            <li>E. g. "14.261".</li>
            <li>If represented as "14261" (A * 1000 = mA) ("1110101001100000"), requires at least 16 bits (from 00000 to 60000, at least; in pure binary representation without point).</li>
        </ul>
    </li>
    <li>
        Active power (kW):
        <ul>
            <li>E. g. "1.249".</li>
            <li>If represented as "1249" (kW * 1000 = W) ("10011100001"), requires at least 13 bits (from 0000 to 5000, at least; in pure binary representation without point).</li>
        </ul>
    </li>
    <li>
        Voltage (V):
        <ul>
            <li>E. g. "225.8".</li>
            <li>If represented as "2258" (V * 10) ("100011010010"), requires at least 13 bits (from 0000 to 5000, at least; in pure binary representation without point).</li>
            <li>In the following data, the value was always between "220.0" ("2200", "100010011000") and "240.0" ("2400", "100101100000").
        </ul>
    </li>
</ul>

<p>Hint: Active power (kW) * 1000 = Current (A) * Voltage (V)</p>