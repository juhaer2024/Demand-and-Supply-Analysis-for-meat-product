<?php

$divisions = [
    'Dhaka', 'Chattogram', 'Rajshahi', 'Khulna',
    'Barishal', 'Sylhet', 'Rangpur', 'Mymensingh'
];


$meatTypes = ['beef', 'chicken', 'mutton', 'lamb'];


function getNutritionalNeeds(string $personType): array
{
    
    $adultNeeds = [
        'beef' => 150, 'chicken' => 100, 'mutton' => 50, 'lamb' => 30
    ];
    $childNeeds = [
        'beef' => 75, 'chicken' => 50, 'mutton' => 25, 'lamb' => 15
    ];

    return ($personType === 'adult') ? $adultNeeds : $childNeeds;
}


function getPopulationData(int $year): array
{
    
    $basePopulation = [ 
        'Dhaka' => 20000000,  'Chattogram' => 10000000, 'Rajshahi' => 8000000,
        'Khulna' => 7000000,   'Barishal' => 6000000,  'Sylhet' => 5000000,
        'Rangpur' => 7500000, 'Mymensingh' => 6500000
    ];

    
    $growthRate = 0.02; 
    $population = [];
    foreach ($basePopulation as $division => $basePop) {
        $population[$division] = round($basePop * pow(1 + $growthRate, $year - 2020));
    }
    return $population;
}


function getGDPData(int $year): array
{
    
      $gdpData = [
        'Dhaka' => [
            'gdpPerCapita' => 3000,
            'population' => 23000000,
        ],
        'Chattogram' => [
            'gdpPerCapita' => 2700,
            'population' => 10000000,
        ],
        'Rajshahi' => [
            'gdpPerCapita' => 2200,
             'population' => 8000000,
        ],
        'Khulna' => [
            'gdpPerCapita' => 2500,
             'population' => 7000000,
        ],
        'Barishal' => [
            'gdpPerCapita' => 2000,
             'population' => 6000000,
        ],
        'Sylhet' => [
            'gdpPerCapita' => 2800,
             'population' => 5000000,
        ],
        'Rangpur' => [
            'gdpPerCapita' => 2100,
             'population' => 7500000,
        ],
        'Mymensingh' => [
            'gdpPerCapita' => 2300,
            'population' => 6500000,
        ],
    ];
    return $gdpData;
}


function calculateNutritionalDemand(array $populationData, array $adultNeeds, array $childNeeds): array
{
    $totalDays = 365;
    
    $adultRatio = 0.6;
    $childRatio = 0.4;

    $demand = [];
    foreach ($adultNeeds as $meatType => $dailyNeed) {
        $demand[$meatType] = 0;
    }

    foreach ($populationData as $division => $population) {
        foreach ($adultNeeds as $meatType => $dailyNeed) {
            $demand[$meatType] +=
                ($population * $adultRatio * $dailyNeed * $totalDays) +
                ($population * $childRatio * $childNeeds[$meatType] * $totalDays);
        }
    }

    
    foreach ($demand as $meatType => $quantity) {
        $demand[$meatType] = round($quantity / 1000);
    }
    return $demand;
}


function calculateEconomicDemand(float $perCapitaIncome, int $population): array {
    $exchangeRate = 110;  // 1 USD = 110 taka
    $annualIncomeTaka = $perCapitaIncome * $exchangeRate;

    
    $foodSpendingPercent = 0.30;
    $beefSpendingPercent = 0.15; 
    $chickenSpendingPercent = 0.30;
    $muttonSpendingPercent = 0.20;
    $lambSpendingPercent = 0.05;

    $foodSpending = $annualIncomeTaka * $foodSpendingPercent;

    $meatPrices = [
        'beef' => 600,
        'chicken' => 200,
        'mutton' => 1000,
        'lamb' => 1200,
    ];

    $demand = [];
    $demand['beef'] = ($foodSpending * $beefSpendingPercent) / $meatPrices['beef'] * $population;
    $demand['chicken'] = ($foodSpending * $chickenSpendingPercent) / $meatPrices['chicken'] * $population;
    $demand['mutton'] = ($foodSpending * $muttonSpendingPercent) / $meatPrices['mutton'] * $population;
    $demand['lamb'] = ($foodSpending * $lambSpendingPercent) / $meatPrices['lamb'] * $population;

    return array_map('round', $demand);
}




$year = 2023;


$adultNeeds = getNutritionalNeeds('adult');
$childNeeds = getNutritionalNeeds('child');
$populationData = getPopulationData($year);
$gdpData = getGDPData($year);


$nutritionalDemand = calculateNutritionalDemand($populationData, $adultNeeds, $childNeeds);

$economicDemand = [];
foreach ($divisions as $division) {
    $economicDemand[$division] = calculateEconomicDemand(
        $gdpData[$division]['gdpPerCapita'],
        $gdpData[$division]['population']
    );
}

// 5. Output
// ----------
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meat Demand Calculator (Bangladesh - <?php echo $year; ?>)</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000; /* Black background */
            color: #dc3545;
        }

        .container {
            max-width: 960px;
            margin: 20px auto;
            padding: 20px;
            background-color: #000;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }

        h1, h2, h3 {
            text-align: center;
            color: #fff; /* White headlines */
            margin-bottom: 20px;
        }

        h3 {
            margin-top: 30px;
            color: #fff;
        }

        p{
            color: #dc3545;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            border: 1px solid #555;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #555;
            text-align: right;
            color: #dc3545;
        }

        th {
            background-color: #222;
            color: #fff;
            text-align: left;
        }

        tbody tr {
            background-color: #000;
        }

        tbody tr:hover {
            background-color: #333;
        }

        @media screen and (max-width: 600px) {
            table {
                display: block;
                overflow-x: auto;
            }
        }

        .data-section {
            margin-top: 40px;
            border-top: 2px solid #555;
            padding-top: 20px;
        }

        .data-section h3 {
            color: #fff;
            text-align: left;
            margin-bottom: 20px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #555;
        }

        .data-table th, .data-table td {
            padding: 10px;
            border-bottom: 1px solid #555;
            text-align: left;
            color: #dc3545;
        }

        .data-table th {
            background-color: #222;
            color: #fff;
        }

        .data-table tbody tr:nth-child(odd) {
            background-color: #111;
        }

        .equation {
            margin-bottom: 10px;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Meat Demand of BD</h1>
        <h2>Year: <?php echo $year; ?></h2>

        <p>
            This page calculates the estimated demand for meat products in Bangladesh for the year <?php echo $year; ?>.  The calculations are based on two primary factors: nutritional needs and economic capacity (GDP).  The data is simulated, representing the kind of information that would be sourced from the World Health Organization (WHO) and the Bangladesh Bureau of Statistics (BBS) in a real-world application.
        </p>

        <h3>Data Sources:</h3>
        <ul>
            <li><strong>World Health Organization (WHO):</strong> Nutritional requirements for adults and children.</li>
            <li><strong>Bangladesh Bureau of Statistics (BBS):</strong> Population data and GDP information for each division.</li>
        </ul>

        <h3>Methodology:</h3>
        <p>
            The script calculates meat demand using two approaches: nutritional needs and economic capacity.  The final demand is presented from both perspectives for comparison.
        </p>

        <ol>
            <li><strong>Nutritional Demand:</strong>
                <p>
                    This approach calculates the demand based on the population's nutritional requirements for meat.
                </p>
                <ul>
                    <li><b>1.1 Daily Nutritional Needs:</b>
                        <p>
                            The daily nutritional needs for meat (beef, chicken, mutton, and lamb) for adults and children are obtained from simulated WHO data.
                            <br>
                            For example, the daily need for beef for an adult is assumed to be 150 grams, while for a child, it is 75 grams.
                        </p>
                        
                    </li>
                    <li><b>1.2 Population Scaling:</b>
                        <p>
                           The daily needs are scaled to the total population in each of the 8 divisions of Bangladesh.  A simplified adult/child ratio is used (60% adults, 40% children).
                        </p>
                         
                    </li>
                    <li><b>1.3 Annual Demand Calculation:</b>
                        <p>
                            The total annual demand for each meat type in each division is calculated by multiplying the scaled daily needs by the number of days in a year (365) and converting grams to kilograms.
                        </p>
                        
                    </li>
                </ul>
            </li>
            <li><strong>Economic Demand:</strong>
                <p>This approach calculates the demand based on the economic capacity (GDP) of the population in each division.</p>
                <ul>
                    <li><b>2.1 Annual per capita income in Taka:</b>
                        <p>
                            The annual per capita income for each division is calculated by converting USD to Taka.
                        </p>
                         <p class="equation">
                           Annual per capita income in Taka = Per capita income (USD) * Exchange Rate (1 USD = 110 Taka)
                        </p>
                    </li>
                    <li><b>2.2 Annual food spending per person:</b>
                        <p>
                            The annual food spending per person is calculated by multiplying the annual per capita income in Taka by the percentage of income spent on food.
                        </p>
                        <p class="equation">
                            Annual food spending per person = Annual per capita income in Taka * Percentage of income spent on food
                        </p>
                    </li>
                    <li><b>2.3 Annual spending on meat per person:</b>
                         <p>
                            The annual spending on meat per person is calculated by multiplying the annual food spending per person by the percentage of food spending on the specific meat.
                         </p>
                         <p class="equation">
                            Annual spending on meat per person  = Annual food spending per person * Percentage of food spending on the specific meat
                         </p>
                    </li>
                    <li><b>2.4 Annual meat consumption per person:</b>
                        <p>
                            The annual meat consumption per person is calculated by dividing the annual spending on meat per person by the price of the meat per kg.
                        </p>
                        <p class="equation">
                            Annual meat consumption per person = Annual spending on meat per person / Price of the meat per kg
                        </p>
                    </li>
                    <li><b>2.5 Total annual meat demand:</b>
                        <p>
                            The total annual meat demand for the division is calculated by multiplying the annual meat consumption per person by the population of the division.
                        </p>
                        <p class="equation">
                           Total annual meat demand = Annual meat consumption per person * Population of the division
                        </p>
                    </li>
                </ul>
            </li>
        </ol>

        <h3>Assumptions:</h3>
        <ul>
            <li>Adult/Child ratio is assumed to be 60/40.</li>
            <li>A simplified annual growth rate is used for population projection.</li>
            <li>Food and meat spending percentages are based on simulated data.</li>
        </ul>

        <div class="data-section">
            <h3>Raw Data</h3>
            <h4>Nutritional Needs (Simulated WHO Data)</h4>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Person Type</th>
                        <th>Beef (g/day)</th>
                        <th>Chicken (g/day)</th>
                        <th>Mutton (g/day)</th>
                        <th>Lamb (g/day)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Adult</td>
                        <td><?php echo $adultNeeds['beef']; ?></td>
                        <td><?php echo $adultNeeds['chicken']; ?></td>
                        <td><?php echo $adultNeeds['mutton']; ?></td>
                        <td><?php echo $adultNeeds['lamb']; ?></td>
                    </tr>
                    <tr>
                        <td>Child</td>
                        <td><?php echo $childNeeds['beef']; ?></td>
                        <td><?php echo $childNeeds['chicken']; ?></td>
                        <td><?php echo $childNeeds['mutton']; ?></td>
                        <td><?php echo $childNeeds['lamb']; ?></td>
                    </tr>
                </tbody>
            </table>

            <h4>Population and GDP Data (Simulated BBS Data for <?php echo $year; ?>)</h4>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Division</th>
                        <th>Population (millions)</th>
                        <th>GDP per Capita (USD)</th>
                        <th>Income Spent on Food (%)</th>
                        <th>Beef Spending (%)</th>
                        <th>Chicken Spending (%)</th>
                        <th>Mutton Spending (%)</th>
                        <th>Lamb Spending (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $divisionData = [
                        'Dhaka' => ['population' => 23, 'gdpPerCapita' => 3000, 'food' => 30, 'beef' => 15, 'chicken' => 30, 'mutton' => 20, 'lamb' => 5],
                        'Chattogram' => ['population' => 10, 'gdpPerCapita' => 2700, 'food' => 35, 'beef' => 14, 'chicken' => 32, 'mutton' => 18, 'lamb' => 6],
                        'Rajshahi' => ['population' => 8, 'gdpPerCapita' => 2200, 'food' => 40, 'beef' => 12, 'chicken' => 35, 'mutton' => 15, 'lamb' => 8],
                        'Khulna' => ['population' => 7, 'gdpPerCapita' => 2500, 'food' => 38, 'beef' => 13, 'chicken' => 33, 'mutton' => 17, 'lamb' => 7],
                        'Barishal' => ['population' => 6, 'gdpPerCapita' => 2000, 'food' => 45, 'beef' => 11, 'chicken' => 40, 'mutton' => 14, 'lamb' => 9],
                        'Sylhet' => ['population' => 5, 'gdpPerCapita' => 2800, 'food' => 32, 'beef' => 14, 'chicken' => 30, 'mutton' => 20, 'lamb' => 6],
                        'Rangpur' => ['population' => 7.5, 'gdpPerCapita' => 2100, 'food' => 42, 'beef' => 12, 'chicken' => 38, 'mutton' => 16, 'lamb' => 8],
                        'Mymensingh' => ['population' => 6.5, 'gdpPerCapita' => 2300, 'food' => 41, 'beef' => 13, 'chicken' => 36, 'mutton' => 17, 'lamb' => 7],
                    ];
                    foreach ($divisionData as $divisionName => $data) {
                        echo "<tr>";
                        echo "<td>{$divisionName}</td>";
                        echo "<td>{$data['population']}</td>";
                        echo "<td>{$data['gdpPerCapita']}</td>";
                        echo "<td>{$data['food']}</td>";
                        echo "<td>{$data['beef']}</td>";
                        echo "<td>{$data['chicken']}</td>";
                        echo "<td>{$data['mutton']}</td>";
                        echo "<td>{$data['lamb']}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <h4>Meat Prices (Taka per kg)</h4>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Meat Type</th>
                        <th>Price (Taka/kg)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Beef</td>
                        <td>600</td>
                    </tr>
                    <tr>
                        <td>Chicken</td>
                        <td>200</td>
                    </tr>
                    <tr>
                        <td>Mutton</td>
                        <td>1000</td>
                    </tr>
                     <tr>
                        <td>Lamb</td>
                        <td>1200</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3>Nutritional Demand</h3>
        <p>The following table shows the total annual demand for meat products in Bangladesh, calculated based on the nutritional needs of the population.</p>
        <table>
            <thead>
                <tr>
                    <th>Meat Type</th>
                    <th>Total Demand (KG)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nutritionalDemand as $meatType => $demand): ?>
                    <tr>
                        <td><?php echo ucfirst($meatType); ?></td>
                        <td><?php echo number_format($demand); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Economic Demand by Division</h3>
        <p>The following tables show the annual demand for meat products in each of the 8 divisions of Bangladesh, calculated based on the economic capacity (GDP) of the population.</p>
        <table>
            <thead>
                <tr>
                    <th>Division</th>
                    <th>Beef Demand (kg)</th>
                    <th>Chicken Demand (kg)</th>
                    <th>Mutton Demand (kg)</th>
                    <th>Lamb Demand (kg)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($divisions as $division):  ?>
                <tr>
                    <td><?php echo $division; ?></td>
                    <td><?php echo number_format($economicDemand[$division]['beef']); ?></td>
                    <td><?php echo number_format($economicDemand[$division]['chicken']); ?></td>
                    <td><?php echo number_format($economicDemand[$division]['mutton']); ?></td>
                    <td><?php echo number_format($economicDemand[$division]['lamb']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
