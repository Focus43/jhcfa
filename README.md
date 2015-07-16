# Center For The Arts

To hack on this project, you'll need VirtualBox and Vagrant installed on your local machine. The `vagrant` directory
is a submodule, thus you'll to initialize it. From the project root, use the command below to initialize the vagrant
submodule (and any other ones relevant in the project):

```
$: git submodule update --init --recursive
```

The `vagrant` dir doesn't track your project's provisioning settings. Copy and rename the file `vagrant-setup.copy-me.yml'
from the project root to `vagrant/provisioning/setup.yml` (it should sit beside another file called setup.sample.yml).

Finally, from the vagrant directory: `$: vagrant up`

---

The first time you run Vagrant, it will take a while to provision itself. When you're done working on the project
for the day, `$: vagrant halt`. To work on the project in the future, just restart the VM and start going with
`$: vagrant up` again.