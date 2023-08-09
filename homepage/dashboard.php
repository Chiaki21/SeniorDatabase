<?php
session_start();

if (!isset($_COOKIE['Email_Cookie']) || !isset($_SESSION['logged_in'])) {
  header("Location: ../index.php");
  exit();
}

include('connect.php');
$sql = "SELECT * FROM register";


include('../configuration/config.php');
$email = $_COOKIE['Email_Cookie'];
$autoOutQuery = "SELECT autoOut FROM register WHERE email='{$email}'";
$autoOutResult = mysqli_query($conx, $autoOutQuery);
$autoOutRow = mysqli_fetch_assoc($autoOutResult);
$autoOut = $autoOutRow['autoOut'];

$forStatus = "SELECT status FROM register WHERE email='{$email}'";
$forStatusResult = mysqli_query($conx, $forStatus);
$forStatusRow = mysqli_fetch_assoc($forStatusResult);
$forStatus1 = $forStatusRow['status'];

$forOffline = "SELECT activeStatus FROM register WHERE email='{$email}'";
$forOfflineResult = mysqli_query($conx, $forOffline);
$forOfflineRow = mysqli_fetch_assoc($forOfflineResult);
$forOffline1 = $forOfflineRow['activeStatus'];

if ($autoOut == 'Yes' || $forStatus1 == 'Disabled' || $forOffline1 == 'Offline') {
  include("logoutupdate.php");
  exit();
}

if ($_SESSION['role'] === 'User') {
  $error_msg = 'You are in "User" only role, contact your supervisor for assistance';
} else {
  include("connect.php");
  $sql = "SELECT * FROM register";
  $result = $conx->query($sql);
}
$sqlCount = "SELECT COUNT(id) AS total FROM people";
$totalResult = mysqli_query($conn, $sqlCount);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalRegistrants = $totalRow['total'];
$sql = "SELECT * FROM register";
$result = $conx->query($sql);
$currentDate = date('Y-m-d');
$todaySql = "SELECT COUNT(*) AS today FROM people WHERE DATE(updated_date) = '$currentDate'";
$todayResult = mysqli_query($conn, $todaySql);
$todayRow = mysqli_fetch_assoc($todayResult);
$todayRegistrants = $todayRow['today'];
$currentYear = date('Y');
if (isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
  $searchQuery = $_GET['searchQuery'];
  $sqlCount = "SELECT COUNT(*) as total FROM people WHERE firstName LIKE '%$searchQuery%' OR lastName LIKE '%$searchQuery%' OR RBIID LIKE '%$searchQuery%' OR middleName LIKE '%$searchQuery%'";
  $sqlSelect = "SELECT * FROM people WHERE firstName LIKE '%$searchQuery%' OR lastName LIKE '%$searchQuery%' OR RBIID LIKE '%$searchQuery%' OR middleName LIKE '%$searchQuery%' ORDER BY updated_date DESC LIMIT $offset, $recordsPerPage";
} else {
  $sqlCount = "SELECT COUNT(*) as total FROM people WHERE YEAR(updated_date) = $currentYear";
}
$totalSql = "SELECT COUNT(*) AS total FROM people WHERE YEAR(updated_date) = $currentYear";
$totalResult = mysqli_query($conn, $totalSql);
$totalRow = mysqli_fetch_assoc($totalResult);
$selectedYear = $currentYear;
if (isset($_GET['selectYear'])) {
  $selectedYear = $_GET['selectYear'];
}
$registrantsData = array();
for ($month = 1; $month <= 12; $month++) {
  $monthSql = "SELECT COUNT(*) AS count FROM people WHERE YEAR(updated_date) = $selectedYear AND MONTH(updated_date) = $month";
  $monthResult = mysqli_query($conn, $monthSql);
  $monthRow = mysqli_fetch_assoc($monthResult);
  $registrantsData[] = (int)$monthRow['count'];
}
$latestPersonsSql = "SELECT id, lastName, firstName, extensionName, imageup FROM people ORDER BY updated_date DESC LIMIT 10";
$latestPersonsResult = mysqli_query($conn, $latestPersonsSql);
$latestPersons = array();
while ($row = mysqli_fetch_assoc($latestPersonsResult)) {
  $latestPersons[] = $row;
}
$activeSenior = "SELECT COUNT(*) AS activeCount FROM people WHERE personStatus = 'Active'";
$activeSeniorResult = mysqli_query($conn, $activeSenior);
$activeSeniorRow = mysqli_fetch_assoc($activeSeniorResult);
$activeCount = $activeSeniorRow['activeCount'];

$onlineUsersQuery = "SELECT COUNT(*) AS onlineCount FROM register WHERE activeStatus = 'Online'";
$onlineUsersResult = mysqli_query($conx, $onlineUsersQuery);
$onlineUsersRow = mysqli_fetch_assoc($onlineUsersResult);
$onlineUsersCount = $onlineUsersRow['onlineCount'];


?>




<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <title>Senior Solutions | Admin Dashboard</title>


  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="../img/sslogo.png">
  <style>
    .home-content {
      padding: 20px;
    }


    .btn-container {
      display: flex;
      justify-content: space-between;
      gap: 10px;
    }

    .btn {
      display: inline-block;
      padding: 10px 15px;
      border-radius: 4px;
      font-size: 14px;
      text-align: center;
      text-decoration: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .select-box {
      display: inline-block;
      position: relative;
    }

    .select-box label {
      display: block;
      margin-bottom: 5px;
    }

    .select-box select {
      width: 100px;
      padding: 8px 30px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background-color: #fff;
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
    }

    .select-box select:focus {
      outline: none;
      border-color: blue;
    }

    .select-box::before {
      content: "\25BC";
      position: absolute;
      top: 70%;
      right: 10px;
      transform: translateY(-50%);
      pointer-events: none;
    }

    .btn-more {
      background-color: #5250b1;
      color: white;
      user-select: none;
      border: none;
    }

    .btn-more:hover {
      background-color: #3e3cb8;
    }

    .btn-more:active {
      background-color: #0a07db;
    }

    canvas {
      cursor: pointer;
    }

    .horizontalBar {
      width: 100%;
      padding: 20px;
      background: white;

    }
  </style>
  <script src="https://cdn.plot.ly/plotly-2.16.1.min.js"></script>
</head>

<body>
  <?php if (isset($error_msg)) : ?>
    <div class="error-container">
      <div class="error-message"><?php echo $error_msg; ?></div>
      <button class="go-back-button" onclick="goBack()">Go back</button>
    </div>

    <script>
      function goBack() {
        window.history.back();
      }
    </script>
  <?php else : ?>

    <div class="sidebar">
      <div class="logo-details">
        <a href="homelog.php">
          <img src="../img/sslogo.png" alt="" class="logo-details">
        </a>
        <span class="logo_name">Senior Solutions</span>
      </div>
      <ul class="nav-links">
        <li>
          <a href="dashboard.php" class="active">
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="homelog.php">
            <i class="bx bx-list-ul"></i>
            <span class="links_name">Record Lists</span>
          </a>
        </li>

        <li>
          <a href="userlog.php">
            <i class="bx bx-user"></i>
            <span class="links_name">User Log</span>
          </a>
        </li>
        <li>
          <a href="addrecord.php">
            <i class="bx bx-box"></i>
            <span class="links_name">Add Record</span>
          </a>
        </li>


        <li class="log_out">
          <a href="logout.php" id="logoutLink">
            <i class="bx bx-log-out"></i>
            <span class="links_name">Log out</span>
          </a>
        </li>
      </ul>
    </div>

    <section class="home-section" style="background-color: lightblue;">

      <nav>
        <div class="sidebar-button">
          <i class="bx bx-menu sidebarBtn"></i>
          <span class="dashboard">Dashboard</span>
        </div>

        <form action="search.php" method="GET" class="search-box">
          <input type="text" placeholder="Search..." name="searchQuery" id="searchInput" required />
          <button type="submit" class="bx bx-search"></button>
        </form>



        <div class="profile-details">
          <img src="../img/profilepicture.jpg" alt="">
          <span class="admin_name">
            <?php
            if (isset($_SESSION['user_name'])) {
              echo $_SESSION['user_name'];
            }
            ?>
          </span>
          <!--
    <i class="bx bx-chevron-down"></i>
      -->
        </div>
      </nav>
      <div class="home-content">

        <div class="overview-boxes">

          <div class="box" onclick="location.href='homelog.php';">
            <div class="right-side">
              <div class="box-topic" style="margin-right:100px">Total Registrants</div>
              <div class="number"><?php echo $totalRegistrants; ?></div>
              <div class="indicator">
                <i class='bx bx-up-arrow-alt'></i>
                <span class="text">Up from today</span>
              </div>
            </div>
          </div>



          <div class="box" onclick="location.href='todayreg.php';">
            <div class="right-side">
              <div class="box-topic" style="margin-right:100px">Today's Registrants</div> <!-- CHANGE TO Month's Registrants-->
              <div class="number"><?php echo $todayRegistrants; ?></div>
              <div class="indicator">
                <i class='bx bx-up-arrow-alt'></i>
                <span class="text">Up from today</span>
              </div>
            </div>
          </div>

          <div class="box" onclick="location.href='activeseniors.php';">
            <div class="right-side">
              <div class="box-topic" style="margin-right:100px">Active Seniors</div>
              <div class="number"><?php echo $activeCount; ?></div>
              <div class="indicator">
                <i class='bx bx-up-arrow-alt'></i>
                <span class="text">Up from today</span>
              </div>
            </div>

          </div>
          <div class="box" onclick="location.href='userlog.php';">
            <div class="right-side">
              <div class="box-topic">Current Online User</div>
              <div class="number"><?php echo $onlineUsersCount; ?></div>
              <div class="indicator">
                <i class='bx bx-up-arrow-alt'></i>
                <span class="text">Up from today</span>
              </div>
            </div>
          </div>

        </div>

        <div class="sales-boxes">

          <div class="recent-sales box">
            <div class="select-box">
              <h1>Select Year</h1>
              <select name="selectYear" onchange="handleYearChange(this.value)" style="cursor:pointer">
                <option hidden><?php echo $selectedYear; ?></option>
                <option><?php echo $currentYear; ?></option>
                <option><?php echo $currentYear - 1; ?></option>
                <option><?php echo $currentYear - 2; ?></option>
                <option><?php echo $currentYear - 3; ?></option>
                <option><?php echo $currentYear - 4; ?></option>
              </select>
            </div>
            <label>This year's registrants.</label>
            <div><canvas id="myChart" height="500"></canvas></div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
              const yearChart = document.getElementById('myChart');
              let chartData = <?php echo json_encode($registrantsData); ?>;

              initializeChart();

              function initializeChart() {
                const chart = new Chart(yearChart, {
                  type: 'line',
                  data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: [{
                      label: '# of registrants',
                      data: chartData,
                      borderColor: 'blue',
                      pointBackgroundColor: 'blue',
                      pointRadius: 4,
                      pointHoverRadius: 20,
                      pointHitRadius: 20,
                      pointHoverBackgroundColor: 'lightblue',
                      fill: {
                        target: 'origin',
                      },
                      backgroundColor: 'rgb(62,149,205,0.5)',
                    }]
                  },
                  options: {
                    animation: {
                      duration: 5000,
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                      x: {
                        title: {
                          display: true,
                          text: 'Month',
                          color: 'blue',
                        },
                        grid: {
                          display: true,
                        },
                      },
                      y: {
                        beginAtZero: true,
                        title: {
                          display: true,
                          text: 'Registrants',
                          color: 'blue',
                        },
                      }
                    },
                    plugins: {
                      tooltip: {
                        enabled: true,
                        titleFont: {
                          size: 18,
                        },
                        bodyFont: {
                          size: 19,
                        },
                      },
                    },
                    onClick: (event, elements) => {
                      if (elements && elements.length > 0) {
                        const index = elements[0].index;
                        const selectedMonth = index + 1;
                        const selectedYear = document.querySelector('select[name="selectYear"]').value;
                        window.location.href = `month.php?year=${selectedYear}&month=${selectedMonth}`;
                      }
                    }
                  }
                });
                chart.canvas.style.cursor = 'pointer';
              }

              function handleYearChange(selectedYear) {
                window.location.href = '?selectYear=' + selectedYear;
              }
            </script>
          </div>



          <!-- RECENT PERSON ADDED -->
          <div class="top-sales box">
            <div class="title">Recent Person Added <button class="btn btn-more" onclick="window.location.href='homelog.php'">See More</button></div>
            <ul class="top-sales-details">

              <?php foreach ($latestPersons as $person) : ?>

                <li class="personfield" onclick="window.location.href='view.php?id=<?php echo $person['id']; ?>';">
                  <a>
                    <?php if (!empty($person['imageup']) && $person['imageup'] !== 'imageuploaded/') : ?>
                      <img src="<?php echo $person['imageup']; ?>" alt="">
                    <?php else : ?>
                      <img src="../img/profilepicture.jpg" alt="">
                    <?php endif; ?>
                    <span class="recentname"><?php echo $person['lastName']; ?></span>
                    <span class="recentname"><?php echo $person['firstName']; ?></span>
                    <span class="recentname"><?php echo $person['extensionName']; ?></span>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>

        <br>
        <h1 style="padding:20px; font-size:30px">More Charts</h1>

        <div class="sales-boxes">



          <!-- AGE CHART -->

          <div class="recent-sales box">
            <h1>Ages</h1>
            <div><canvas id="ageChart" height="600"></canvas></div>
            <?php include 'areachart.php'; ?>
            <script>
              const ageChart = document.getElementById('ageChart');
              const registrantsData = <?php echo json_encode($registrantsData); ?>;

              new Chart(ageChart, {
                type: 'line',
                data: {
                  labels: ['60', '61', '62', '63', '64', '65', '66', '67', '68', '69', '70', '71', '72', '73', '74', '75', '76', '77', '78', '79', '80', '81', '82', '83', '84', '85', '86', '87', '88', '89', '90', '91', '92', '93', '94', '95', '96', '97', '98', '99', '100'],
                  datasets: [{
                    label: 'Range of Ages',
                    data: registrantsData,
                    borderColor: 'blue',
                    pointBackgroundColor: 'blue',
                    backgroundColor: 'rgb(62,149,205,0.5)',
                    pointRadius: 4,
                    pointHoverRadius: 20,
                    pointHitRadius: 20,
                    pointHoverBackgroundColor: 'lightblue',
                    pointStyle: 'circle',
                    fill: {
                      target: 'origin',
                    },
                    backgroundColor: 'rgb(62,149,205,0.5)',
                  }]
                },
                options: {
                  animation: {
                    duration: 5000,
                  },
                  responsive: true,
                  maintainAspectRatio: false,
                  scales: {
                    x: {
                      ticks: {
                        color: 'red',
                        font: {
                          size: 13,
                        }
                      },
                      title: {
                        display: true,
                        text: 'Age',
                        color: 'blue',
                      }
                    },
                    y: {
                      ticks: {
                        stepSize: 1
                      }
                    }

                  },
                  plugins: {
                    tooltip: {
                      callbacks: {
                        label: function(context) {
                          var label = context.label || '';
                          if (label) {
                            label += " year's old: ";
                          }
                          label += context.formattedValue;
                          return label;
                        }
                      },
                      bodyFont: {
                        size: 19
                      },
                      titleFont: {
                        size: 18
                      }
                    }
                  },
                  onClick: function(event, chartElement) {
                    if (chartElement.length > 0) {
                      const dataIndex = chartElement[0].index;
                      const selectedAge = 60 + dataIndex;
                      window.location.href = "age.php?age=" + selectedAge;
                    }
                  }
                }
              });
            </script>
          </div>


          <!-- PIE CHART FOR GENDER -->

          <div class="bottomcharts">
            <h1>Gender</h1>
            <div><canvas id="pieChartGender" height="200"></canvas></div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script>

            <?php include 'piechartgender.php'; ?>
            <script>
              const pieChartGender = document.getElementById('pieChartGender');
              const labels = <?php echo $labels_json; ?>;
              const data = <?php echo $data_json; ?>;
              const colors = <?php echo $colors_json; ?>;
              const chart = new Chart(pieChartGender, {
                type: 'pie',
                data: {
                  labels: labels,
                  datasets: [{
                    label: '# of registrants',
                    data: data,
                    backgroundColor: colors,
                    hoverOffset: 4,
                  }]
                },
                options: {
                  animation: {
                    duration: 5000,
                  },
                  responsive: true,
                  maintainAspectRatio: false,
                  plugins: {
                    labels: {
                      render: (args) => {
                        return args.label;
                      },
                      fontSize: 13,
                      fontColor: 'white',
                    },
                  },
                },
              });
              pieChartGender.addEventListener('mouseenter', function() {
                pieChartGender.classList.add('pointer');
              });
              pieChartGender.addEventListener('mouseleave', function() {
                pieChartGender.classList.remove('pointer');
              });
              pieChartGender.onclick = function(event) {
                const activeElement = chart.getElementsAtEventForMode(event, 'nearest', {
                  intersect: true
                }, true)[0];
                if (activeElement) {
                  const label = labels[activeElement.index];
                  window.location.href = 'gender.php?gender=' + encodeURIComponent(label);
                }
              };
            </script>
            <br>
            <hr>

            <!-- DISABIITIES RADAR CHART! -->

            <h1>Disabilities</h1>
            <div><canvas id="radarChart" height="300"></canvas></div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <?php include 'radarchart.php'; ?>
            <script>
              const radarChart = document.getElementById('radarChart');
              const radarChartData = <?php echo json_encode($data); ?>;
              const disabilities = <?php echo json_encode($disabilities); ?>;

              const getDisability = (index) => {
                if (index >= 0 && index < disabilities.length) {
                  return disabilities[index];
                }
                return '';
              };
              Chart.defaults.font.size = 15;
              new Chart(radarChart, {
                type: 'radar',
                data: {
                  labels: <?php echo json_encode($labels); ?>,
                  datasets: [{
                    label: 'Disabilities',
                    data: radarChartData,
                    fill: true,
                    backgroundColor: 'rgba(255,99,132,0.2)',
                    borderColor: 'rgb(255,99,132)',
                    pointBackgroundColor: 'rgb(255,99,132)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(255,99,132)',
                    pointRadius: 4,
                    pointHoverRadius: 20,
                    pointHitRadius: 20,
                  }],
                },
                options: {
                  animation: {
                    duration: 5000,
                  },
                  elements: {
                    line: {
                      borderWidth: 3
                    }
                  },
                  responsive: true,
                  maintainAspectRatio: false,
                  scales: {
                    r: {
                      beginAtZero: true,
                      ticks: {
                        font: {
                          size: 16,
                        }
                      },
                      pointLabels: {
                        font: {
                          size: 15,
                        }
                      },
                    },
                  },
                  onClick: function(event, elements) {
                    if (elements.length > 0) {
                      const index = elements[0].index;
                      const disability = getDisability(index);
                      window.location.href = `disabilities.php?disability=${encodeURIComponent(disability)}`;
                    }
                  },
                },
              });
            </script>
          </div>

        </div>
        <br>

        <div class="sales-boxes">
          <div class="horBarChart box">

            <div class="chartCard">
              <div class="horizontalBar">
                <h1>Barangay</h1>
                <canvas id="horBar"></canvas>
              </div>
            </div>
            <?php include 'barChart.php'; ?>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
            <script>
              const myData = {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                  label: ' People',
                  data: <?php echo json_encode($data); ?>,
                  backgroundColor: [
                    'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue', 'lightblue'
                  ],
                  borderColor: 'blue',
                  borderWidth: 2
                }]
              };
              const horBar = new Chart(
                document.getElementById('horBar'), {
                  type: 'bar',
                  data: myData,
                  options: {
                    indexAxis: 'y',
                    scales: {
                      y: {
                        beginAtZero: true,
                        ticks: {
                          font: {
                            size: 16
                          }
                        }
                      },
                      x: {
                        grid: {
                          display: false
                        },
                        ticks: {
                          font: {
                            size: 20
                          },
                          stepSize: 1
                        }
                      }
                    },
                    plugins: {
                      legend: {
                        display: false
                      },
                      tooltip: {
                        bodyFont: {
                          size: 19
                        },
                        titleFont: {
                          size: 21
                        }
                      }
                    },
                    onClick: handleBarClick
                  }
                }
              );

              function handleBarClick(event) {
                const activeBar = horBar.getElementsAtEventForMode(event, 'index', {
                  intersect: true
                });
                if (activeBar.length) {
                  const selectedBarIndex = activeBar[0].index;
                  const selectedBarangay = myData.labels[selectedBarIndex];
                  const url = `barangay.php?barangay=${encodeURIComponent(selectedBarangay)}`;
                  window.location.href = url;
                }
              }
            </script>


          </div>

        </div>
        <br><br>
        <footer>
          <p>&copy; 2023 Senior Database System. All rights reserved.</p>
          <p style="color:lightblue">System Programmed by Justine Luzano.</p>
          <p style="color:lightblue">Logo Made By Michael Glen Flores.</p>
        </footer>
      </div>





      </div>


    </section>

    <script src="homescript.js"></script>
  <?php endif; ?>
</body>

</html>