<section>
    <h5>MDRRMC MIS INSTALLATION GUIDE</h5>

    <ol>
        <li>Copy the https://github.com/exequieltahop/mdrrmc-mis.git</li>
        <li>Copy the env.exampe into root directory or same as the env.example</li>
        <li>Rename the .env.example into .env</li>
        <li>Then in the terminal, type composer install</li>
        <li>Then type npm install</li>
        <li>Then type composer update</li>
        <li>Then type npm update</li>
        <li>Then type php artisan key:generate</li>
        <li>Make a database name in your (xampp, laragon, etc) </li>
        <li>Change the sqlite into mysql in the .env file</li>
        <li>Make sure to put right credentials in the .env mysql</li>
        <li>In the terminal type php artisan migrate:fresh --seed</li>
    </ol>

    <h5>Requirements</h5>
    <ul>
        <li>git</li>
        <li>composer</li>
        <li>PHP 8.2 Above (xampp updated version)</li>
        <li>node.js</li>
        <li>Mysql</li>
    </ul>
</section>