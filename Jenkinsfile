pipeline {
  agent any
  stages {
    stage('Up') {
      steps {
        sh 'make up'
      }
    }
    stage('Install') {
      steps {
        sh 'make install'
      }
    }
    stage('Build') {
      steps {
        sh 'make create'
        sh 'make build'
      }
    }
    stage('Test') {
      steps {
        sh 'make test'
      }
    }
  }
  post {
    cleanup {
      sh 'docker-compose exec -T app chmod -R 777 ./'
      sh 'make down'
      deleteDir()
    }
  }
}

