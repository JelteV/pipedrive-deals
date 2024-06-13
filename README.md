![img.png](https://careers.recruiteecdn.com/image/upload/q_auto,f_auto,w_400,c_limit/production/images/BKX1/pBCbFREQy3rQ.png)

# Project structure

This project has four branches:

* main 
* feature/deel-1
* feature/deel-2
* feature/deel-3

All the non-main branches are based of the main branch. After completing a feature its merged back into main.

# Prerequisites

* `docker` and `docker-compose` must be installed on your local machine, port `8181` must be available
* `NGROK` must be installed on your local machine, [Download](https://ngrok.com/download)
* You need a valid pipedrive API key, for the [https://regeljelease-sandbox3.pipedrive.com/](https://regeljelease-sandbox3.pipedrive.com/) sandbox environment

# Instructions:

1. Clone this [repository](https://github.com/JelteV/pipedrive-deals) to your local machine
2. Start `NGROK` to make the application reachable for the pipedrive webhook. run from within the project folder, in separate terminal window, <br>
the following command: `make ngrok`. This will make sure incoming traffic will get redirected to `http://localhost:8181`
3. create a copy of `env.dist` and name it `.env`, after creating the `.env` file follow the instruction below:
<br/><br/>
   * In the `.env` file, change the value of `PIPEDRIVE_API_TOKEN` with your pipedrive sandbox API key
   * in the `.env` file, change the value of `NGROK_PUBLIC_URL` with the public `NGROK` forward url, see the terminal window you started `NGROK` in earlier
<br/><br/>
4. Build the docker containers, run from within the project folder: `make build`
5. Start the docker containers, run from within the project folder: `make up`, this will start the containers in detached mode
6. Install the composer dependencies and create the pipedrive webhook by running from within the project folder: `make setup`
7. Run the `PHPUnit` tests for checking if everything is OK, run from within the project folder: `make test`

Now the project is running, configured and ready you can start manipulate deals. Happy testing! :-)

## Other command(s):

* To stop the docker containers, run from within the project folder: `make stop`

# Development notes:

I was not able to make the webhook react on changes when editing the product prices, via the pipedrive webinterface, for the products assign to deal: `Testdeal`. <br>
I worked around this issue by changing the deal value directly via the pipedrive webinterface. I was assuming that if the product prices change the
value of the deal changes too.
