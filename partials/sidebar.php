<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <title>Sidebar</title>
  </head>
  <body>
    <div class="MainSideBar">
  <div class="sidebar">
  <div class="sidebar-logo">
    <img src="./img/LGlogo.png" alt="Lou Geh Library System" />
    <div class="LogoText">
    <h2>LOU GEH</h2>
    <p>LIBRARY SYSTEM</p>
    </div>
  </div>
  <nav class="sidebar-nav">
    <a href="./index.php">
      <button>
          <svg width="24" height="24" fill="#2A5ED4" viewBox="0 0 24 24">
            <path
              d="M19 5v2h-4V5h4ZM9 5v6H5V5h4Zm10 8v6h-4v-6h4ZM9 17v2H5v-2h4ZM21 3h-8v6h8V3ZM11 3H3v10h8V3Zm10 8h-8v10h8V11Zm-10 4H3v6h8v-6Z"
            ></path>
          </svg>
          <span>
            Dashboard
          </span>
      </button>
      </a>
      <a href="./books.php">
      <button>
          <svg width="24" height="24" fill="#2A5ED4" viewBox="0 0 24 24">
            <path
              d="M3 18.5V5a3 3 0 0 1 3-3h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5A3.5 3.5 0 0 1 3 18.5ZM19 20v-3H6.5a1.5 1.5 0 1 0 0 3H19ZM5 15.337A3.485 3.485 0 0 1 6.5 15H19V4H6a1 1 0 0 0-1 1v10.337Z"
            ></path>
          </svg>
          <span>
             Books
          </span>
        </button>
        </a>
        <a href="./readers.php">
        <button>
          <svg width="24" height="24" fill="#2A5ED4" viewBox="0 0 24 24">
            <path
              d="M9 13.75c-2.34 0-7 1.17-7 3.5V19h14v-1.75c0-2.33-4.66-3.5-7-3.5ZM4.34 17c.84-.58 2.87-1.25 4.66-1.25s3.82.67 4.66 1.25H4.34ZM9 12c1.93 0 3.5-1.57 3.5-3.5S10.93 5 9 5 5.5 6.57 5.5 8.5 7.07 12 9 12Zm0-5c.83 0 1.5.67 1.5 1.5S9.83 10 9 10s-1.5-.67-1.5-1.5S8.17 7 9 7Zm7.04 6.81c1.16.84 1.96 1.96 1.96 3.44V19h4v-1.75c0-2.02-3.5-3.17-5.96-3.44ZM15 12c1.93 0 3.5-1.57 3.5-3.5S16.93 5 15 5c-.54 0-1.04.13-1.5.35.63.89 1 1.98 1 3.15s-.37 2.26-1 3.15c.46.22.96.35 1.5.35Z"
            ></path>
          </svg>
          <span>
             Readers
          </span>
          </button>
          </a>

  </nav>
</div>
</div>

<!-- Include the Sidebar CSS -->
<link rel="stylesheet" href="../partials/sidebar.css">

  </body>
</html>
