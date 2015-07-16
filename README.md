# Center For The Arts

To hack on this project, you'll need VirtualBox and Vagrant installed on your local machine. The `vagrant` directory
is a submodule, thus you'll to initialize it. From the project root, use the command below to initialize the vagrant
submodule (and any other ones relevant in the project):

```
$: git submodule update --init --recursive
```

The `vagrant` dir doesn't track your project's provisioning settings. Copy and rename the file `vagrant-setup.copy-me.yml`
from the project root to `vagrant/provisioning/setup.yml` (it should sit beside another file called setup.sample.yml).

From the vagrant directory, do `$: vagrant up`, and Vagrant will build/provision an entire dev environment. (The first time 
you run Vagrant, it will take a while to provision itself and you'll see output streamed from Ansible. When you're done working on the project for the day, `$: vagrant halt`. To work on the project in the future, just restart the VM and start going with 
`$: vagrant up` again.)

---

Once Vagrant is up and running, `$: vagrant ssh` into the machine. You'll be dropped into /home/vagrant directory. Move into the `app` directory then run `$: gulp`; which will watch your project for changes to JS/SCSS files and automatically run builds. Off to the races.