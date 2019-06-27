# Finances-tool

#### If you have vagrant installed, skip these steps:
- install [Vagrant](https://releases.hashicorp.com/vagrant/2.1.4/)
- in cmd (as admin) ```vagrant plugin install nugrant```
- in cmd (as admin)  ```vagrant plugin install vagrant-hostmanager```
#### Then
- git clone https://github.com/martin-velikov/finances-tool/
- cd finances-tool/
- git submodule update --init
- cd vagrant
- copy .vagrantuser file in vagrant folder
- vagrant up
- vagrant ssh
- make all
- project IP is automatically inserted in hosts file and can be accessed by entering ```http://finances-tool.local/``` in your browser

### Tests:
- php ./bin/phpunit
