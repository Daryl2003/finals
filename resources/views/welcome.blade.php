<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ThriftShop</title>
    <!-- Importing the required fonts -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Newsreader:wght@400;500&display=swap"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap"
    />
    
    <style>
      :root {
  --default-font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
    Ubuntu, "Helvetica Neue", Helvetica, Arial, "PingFang SC",
    "Hiragino Sans GB", "Microsoft Yahei UI", "Microsoft Yahei",
    "Source Han Sans CN", sans-serif;
            }

            .main-container {
              overflow: hidden;
            }

            .main-container,
            .main-container * {
              box-sizing: border-box;
            }

            input,
            select,
            textarea,
            button {
              outline: 0;
            }

            .main-container {
              position: relative;
              width: 1440px;
              height: 2092px;
              margin: 0 auto;
              background: #ffffff;
              overflow: hidden;
            }
            .rectangle {
              position: relative;
              width: 1440px;
              height: 112px;
              margin: 5px 0 0 30px;
              z-index: 9;
            }
            .cart-button {
              position: absolute;
              width: 144px;
              height: 59px;
              top: 21px;
              right: 96px;
              cursor: pointer;
              background: #426b1f;
              border: none;
              z-index: 7;
              overflow: hidden;
              border-radius: 8px;
            }
            .cart {
              display: flex;
              align-items: center;
              justify-content: center;
              position: absolute;
              width: 34px;
              height: 21px;
              top: calc(50% - 10px);
              left: calc(50% - 17px);
              color: #ffffff;
              font-family: Inter, var(--default-font-family);
              font-size: 16px;
              font-weight: 600;
              line-height: 20.8px;
              text-align: center;
              white-space: nowrap;
              z-index: 8;
            }
            .thrift-shop {
              display: flex;
              align-items: flex-start;
              justify-content: flex-start;
              position: absolute;
              height: 32px;
              top: 36px;
              left: 66px;
              color: #426b1f;
              font-family: Newsreader, var(--default-font-family);
              font-size: 32px;
              font-weight: 500;
              line-height: 32px;
              text-align: left;
              white-space: nowrap;
              letter-spacing: -0.32px;
              z-index: 3;
            }
            .products {
              display: flex;
              align-items: center;
              justify-content: center;
              position: absolute;
              width: 90px;
              height: 39px;
              top: 36px;
              right: 461px;
              color: #000000;
              font-family: Inter, var(--default-font-family);
              font-size: 16px;
              font-weight: 400;
              line-height: 20.8px;
              text-align: center;
              z-index: 4;
            }
            .register {
              display: flex;
              align-items: center;
              justify-content: center;
              position: absolute;
              width: 90px;
              height: 39px;
              top: 37px;
              right: 262px;
              color: #000000;
              font-family: Inter, var(--default-font-family);
              font-size: 16px;
              font-weight: 400;
              line-height: 20.8px;
              text-align: center;
              z-index: 5;
            }
            .login {
              display: flex;
              align-items: center;
              justify-content: center;
              position: absolute;
              width: 90px;
              height: 34px;
              top: 39px;
              right: 361px;
              color: #000000;
              font-family: Inter, var(--default-font-family);
              font-size: 16px;
              font-weight: 400;
              line-height: 20.8px;
              text-align: center;
              z-index: 6;
            }
            .welcome-to-thrifts {
              display: flex;
              align-items: flex-start;
              justify-content: center;
              position: relative;
              width: 1020px;
              height: 90px;
              margin: 83px 0 0 217px;
              color: #000000;
              font-family: Newsreader, var(--default-font-family);
              font-size: 64px;
              font-weight: 400;
              line-height: 76.8px;
              text-align: center;
              letter-spacing: -1.28px;
            }
            .browse-button {
              position: relative;
              width: 227px;
              height: 54px;
              margin: 0 0 0 613px;
              cursor: pointer;
              background: hsl(92, 55%, 27%);
              border: none;
              z-index: 1;
              overflow: hidden;
              border-radius: 8px;
            }
            .browse-shop {
              display: flex;
              align-items: center;
              justify-content: flex-start;
              position: absolute;
              height: 26px;
              top: calc(50% - 13px);
              left: calc(50% - 81.5px);
              color: white;
              font-family: Inter, var(--default-font-family);
              font-size: 20px;
              font-weight: 600;
              line-height: 26px;
              text-align: left;
              white-space: nowrap;
              z-index: 2;
            }
            .frame {
              position: relative;
              width: 100px;
              height: 100px;
              margin: 608px 0 0 442px;
              z-index: 10;
              overflow: hidden;
            }
     
    </style>
  </head>
  <body>
    <div class="main-container">
      <!-- Header with the navigation menu -->
      <div class="rectangle">
        <button class="cart-button">
          <span class="cart">Cart</span>
        </button>
        <span class="thrift-shop">ThriftApparel</span>
        <a href="/products" class="products">Products</a>
        <a href="/register" class="register">Register</a>
        <a href="/login" class="login">Login</a>
      </div>
      
      <!-- Main welcome section -->
      <span class="welcome-to-thrifts">Welcome To The Thrifts!</span>
      <button class="browse-button" onclick="window.location.href='/login';">
    <span class="browse-shop">Browse our shop</span>
    </button>

      
      <!-- Additional placeholder section -->
      <div class="frame"></div>
    </div>
    <!-- Scripts if needed -->
  
  </body>
</html>
