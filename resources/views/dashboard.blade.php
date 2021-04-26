<x-dashboard>
    <livewire:twitter-tile position="a1:a21" />
    <livewire:statistics-tile position="a22:a24" />

    <livewire:team-member-tile
        position="b1:b8"
        name="Dani"
        :avatar="gravatar('adriaan@spatie.be')"
        birthday="1995-10-22"
    />

    <livewire:team-member-tile
        position="c1:c8"
        name="Henrik"
        :avatar="gravatar('alex@spatie.be')"
        birthday="1996-02-05"
    />

    <livewire:team-member-tile
        position="b9:b16"
        name="Martin"
        :avatar="gravatar('brent@spatie.be')"
        birthday="1994-07-30"
    />

    <livewire:team-member-tile
        position="c9:b16"
        name="Mikkel"
        :avatar="gravatar('freek@spatie.be')"
        birthday="1979-09-22"
    />

    <livewire:time-weather-tile position="e1:e6" />
</x-dashboard>
