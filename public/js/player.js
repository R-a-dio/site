(function () {

  var
    AUDIO_FILE        = 'https://r-a-d.io/main',
    PARTICLE_COUNT    = 250,
    MAX_PARTICLE_SIZE = 8,
    MIN_PARTICLE_SIZE = 1,
    GROWTH_RATE       = 8,
    DECAY_RATE        = 2,

    BEAM_RATE         = 0.8,
    BEAM_COUNT        = 60,

    GROWTH_VECTOR = new THREE.Vector3( GROWTH_RATE, GROWTH_RATE, GROWTH_RATE ),
    DECAY_VECTOR  = new THREE.Vector3( DECAY_RATE, DECAY_RATE, DECAY_RATE ),
    beamGroup     = new THREE.Object3D(),
    particles     = group.children,
    colors        = [ 0xaaee22, 0x04dbe5, 0xff0077, 0xffb412, 0xf6c83d ],
    t, dancer, kick;
    var a = document.getElementById("stream");
  /*
   * Dancer.js magic
   */

  Dancer.setOptions({
    flashSWF : 'lib/soundmanager2.swf',
    flashJS  : 'lib/soundmanager2.js'
  });

  dancer = new Dancer();
  kick = dancer.createKick({
    onKick: function () {
      var i;
      if ( particles[ 0 ].scale.x > MAX_PARTICLE_SIZE ) {
        decay();
      } else {
        for ( i = PARTICLE_COUNT; i--; ) {
          particles[ i ].scale.addSelf( GROWTH_VECTOR );
        }
      }
      // ~~(Math.random() * 255) == Math.floor(Math.random() * 255)
      document.getElementsByTagName("body")[0].style["background-color"] = "rgba(" + ~~(Math.random() * 255) +
       "," + ~~(Math.random() * 255) + "," + ~~(Math.random() * 255) + ", 0.3)";
    },
    offKick: decay,
    threshold: 0.1,
    frequency: [0, 5]
  });

  dancer.onceAt( 0, function () {
    kick.on();
  }).onceAt( 8.2, function () {
    scene.add( beamGroup );
  }).after( 8.2, function () {
    beamGroup.rotation.x += BEAM_RATE;
    beamGroup.rotation.y += BEAM_RATE;
  }).onceAt( 50, function () {
    changeParticleMat( 'blue' );
  }).onceAt( 66.5, function () {
    changeParticleMat( 'pink' );
  }).onceAt( 75, function () {
    changeParticleMat();
  }).fft( document.getElementById( 'fft' ) )
    .load(a)

  Dancer.isSupported() || loaded();
  !dancer.isLoaded() ? dancer.bind( 'loaded', loaded ) : loaded();

  /*
   * Three.js Setup
   */

  function on () {
    for ( var i = PARTICLE_COUNT; i--; ) {
      particle = new THREE.Particle( newParticleMat() );
      particle.position.x = Math.random() * 2000 - 1000;
      particle.position.y = Math.random() * 2000 - 1000;
      particle.position.z = Math.random() * 2000 - 1000;
      particle.scale.x = particle.scale.y = Math.random() * 10 + 5;
      group.add( particle );
    }
    scene.add( group );

    // Beam idea from http://www.airtightinteractive.com/demos/js/nebula/
    var
      beamGeometry = new THREE.PlaneGeometry( 5000, 50, 1, 1 ),
      beamMaterial, beam;

    for ( i = BEAM_COUNT; i--; ) {
      beamMaterial = new THREE.MeshBasicMaterial({
        opacity: 0.5,
        blending: THREE.AdditiveBlending,
        depthTest: false,
        color: colors[ ~~( Math.random() * 5 )]
      });
      beam = new THREE.Mesh( beamGeometry, beamMaterial );
      beam.doubleSided = true;
      beam.rotation.x = Math.random() * Math.PI;
      beam.rotation.y = Math.random() * Math.PI;
      beam.rotation.z = Math.random() * Math.PI;
      beamGroup.add( beam );
    }
  }

  function decay () {
    if ( beamGroup.children[ 0 ].visible ) {
      for ( i = BEAM_COUNT; i--; ) {
        beamGroup.children[ i ].visible = false;
      }
    }

    for ( var i = PARTICLE_COUNT; i--; ) {
      if ( particles[i].scale.x - DECAY_RATE > MIN_PARTICLE_SIZE ) {
        particles[ i ].scale.subSelf( DECAY_VECTOR );
      }
    }
  }

  function changeParticleMat ( color ) {
    var mat = newParticleMat( color );
    for ( var i = PARTICLE_COUNT; i--; ) {
      if ( !color ) {
        mat = newParticleMat();
      }
      particles[ i ].material = mat;
    }
  }

  function newParticleMat( color ) {
    var
      sprites = [ 'pink', 'orange', 'yellow', 'blue', 'green' ],
      sprite = color || sprites[ ~~( Math.random() * 5 )];

    return new THREE.ParticleBasicMaterial({
      blending: THREE.AdditiveBlending,
      size: MIN_PARTICLE_SIZE,
      map: THREE.ImageUtils.loadTexture('/assets/particles/particle_' + sprite + '.png'),
      vertexColor: 0xFFFFFF
    });
  }

  function loaded () {
    var
      loading = document.getElementById( 'loading' ),
      supported = Dancer.isSupported();

    if ( !supported ) {
      $(loading).text("UNSUPPORTED BROWSER")
    } else {
      $(loading).text("RAVE MODO ACTIVATE");
    }

    

    $(loading).click(function(event) {
      dancer.play();
    })

  }

  on();

  // For debugging
  window.dancer = dancer;
  window.newParticleMat = newParticleMat;
  window.changeParticleMat = changeParticleMat;
  window.kick = kick;

})();
